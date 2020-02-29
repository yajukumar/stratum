<?php
//php system/cli/index.php  migrate:OffersApiRequestResponse

class Sessions extends Migration{

    private $table_name = 'stm_sessions';
    private $query = " `id` char(32) NOT NULL,
                        `data` longtext NOT NULL,
                        `last_accessed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                        PRIMARY KEY (`id`)";

    public function up(){
        $oDb = StmFactory::getDbo();
        $final_query = 'CREATE TABLE '.$this->table_name.' '.$this->query;
        $oDb->mysqlQuery($final_query);
        echo  "Table: ".$this->table_name." created.";
    }
}
?>