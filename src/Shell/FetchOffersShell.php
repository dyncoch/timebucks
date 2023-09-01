<?php
/**
 * This script is used to fetch data from the API and save it to the database.
 * It is meant to be run from the command line.
 * @command: bin/cake fetch_offers fetchData
 * @author Lucas Fonseca Martins
 */
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Http\Client;
use App\Model\Table\Offers;

/**
 * FetchOffers shell command.
 */
class FetchOffersShell extends Shell
{
    private $Offers;

    /**
     * Offers table
     */
    public function initialize(): void {
        parent::initialize();
        $this->Offers = $this->loadModel(Offers::class);
    }

    /**
     * Parse and save the data received from the API
     * @param $jsonData
     * @return void
     */
    public function parseAndSaveData($jsonData) {

        // Check encoding and convert to UTF-8 if necessary
        $encoding = mb_detect_encoding($jsonData, ['UTF-8', 'UTF-16', 'UTF-32'], true);
        if ($encoding != 'UTF-8') {
            $jsonData = mb_convert_encoding($jsonData, 'UTF-8', $encoding);
        }

        // Decode JSON data
        $data = json_decode($jsonData, true);

        // Check if data is valid and has the expected structure
        if (!isset($data['status']) || $data['status'] != 'success' || !isset($data['data'])) {
            $this->out("Invalid data received from the API.");
            return;
        }

        // Loop through each offer and insert into the database
        foreach ($data['data'] as $offer) {
            // Create a new entity for the offers table
            $entity = $this->Offers->newEntity([
                'id' => $offer['id'],
                'name' => $offer['name'],
                'requirements' => $offer['requirements'],
                'description' => $offer['description'],
                'epc' => $offer['epc'],
                'click_url' => $offer['click_url'],
                'support_url' => $offer['support_url'],
                'preview_url' => $offer['preview_url'],
                'created' => date('Y-m-d H:i:s')  // Current timestamp
            ]);

            // Before attempting to save
            $errors = $entity->getErrors();

            if (!empty($errors)) {
                // Print out the errors for debugging
                $this->out("Failed to save offer with ID " . $offer['id'] . ". Errors: " . json_encode($errors));
            }

            // Save the entity to the database
            if (!$this->Offers->save($entity)) {
                $this->out("Failed to save offer with ID " . $offer['id']);
            } else {
                $this->out("Saved offer with ID " . $offer['id']);
            }
        }

        $this->out("Data parsed and saved successfully.");
    }

    /**
     * Fetch data from the API
     * @return void
     */
    public function fetchData() {

        $http = new Client();

        // API endpoint
        $url = "https://api.adgatemedia.com/v3/offers/?aff=48864&api_key=155efa664a706f295fb446570041d707&wall_code=o6qb";

        // Fetch data from API
        $response = $http->get($url);

        if ($response->isOk()) {
            // If the response is OK, parse and save the data
            $this->parseAndSaveData($response->getStringBody());
        } else {
            $this->out("Failed to fetch data from API. Status Code: " . $response->getStatusCode());
        }
    }

    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser(): \Cake\Console\ConsoleOptionParser {
        $parser = parent::getOptionParser();

        $parser->setDescription([
            'FetchOffersShell is a command line utility to fetch offers from the API',
            'and save them to the database.',
        ])
            ->addSubcommand('fetchData', [
                'help' => 'Fetches data from the API and saves to the database.',
                'parser' => [
                    'description' => [
                        'This command fetches data from the specified API and then parses',
                        'and saves this data to the offers table in the database.'
                    ]
                ]
            ]);

        return $parser;
    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {
        $this->out($this->OptionParser->help());
    }
}
