<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Network\Http\Client;
use Cake\ORM\TableRegistry;
use App\Model\Table\Offers;

/**
 * FetchOffers shell command.
 */
class FetchOffersShell extends Shell
{

    public $modelClass;
    public $Offers;

    public function initialize() {
        parent::initialize();
        $this->modelClass = $this->loadModel(Offers::class);
        debug(get_class($this->modelClass));
        //$this->Offers = TableRegistry::getTableLocator()->get('Offers');
        //debug(get_class($this->Offers));

    }

    public function parseAndSaveData($jsonData) {
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
            $entity = $this->modelClass->newEntity([
                'id' => $offer['id'],
                'name' => $offer['name'],
                'requirements' => $offer['requirements'],
                'description' => $offer['description'],
                'ecpc' => $offer['epc'], // Rename the field to match the DB column name
                'click_url' => $offer['click_url'],
                'created' => date('Y-m-d H:i:s')  // Current timestamp
            ]);

            // Save the entity to the database
            if (!$this->modelClass->save($entity)) {
                $this->out("Failed to save offer with ID " . $offer['id']);
            }
        }

        $this->out("Data parsed and saved successfully.");
    }

    public function fetchData() {

        $http = new Client();

        // API endpoint
        $url = "https://api.adgatemedia.com/v3/offers/?aff=48864&api_key=155efa664a706f295fb446570041d707&wall_code=o6qb";

        // Fetch data from API
        $response = $http->get($url);

        if ($response->isOk()) {
            // If the response is OK, parse and save the data
            $this->parseAndSaveData($response->body());
        } else {
            $this->out("Failed to fetch data from API. Status Code: " . $response->code);
        }
    }

    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();

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
