<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ConvertIllustrations extends DataConverter
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:illustrations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->convertInChunks(
            database_path('csv/illustrations.csv'),
            1000,
            'Illustraties',
            function ($offset, $limit) {
                return $this->conn->select('
                    SELECT
                        ItemID as item_id,
                        IllustratieFile as filename
                    FROM Illustraties
                    ORDER BY ItemID
                    OFFSET ' . $offset . ' ROWS
                    FETCH NEXT ' . $limit . ' ROWS ONLY
                ');
            },
            function ($illustration) {
                return [
                    'item_id' => $illustration->item_id,
                    'filename' => 'http://iproject1.icasites.nl/pics/' . $illustration->filename
                ];
            }
        );
    }
}
