<?php

use yii\db\Migration;

/**
 * Class m181210_161122_init_meal
 */
class m181210_161122_init_meal extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181210_161122_init_meal cannot be reverted.\n";

        return false;
    }

    public function up()
    {
        $this->batchInsert('meal', ['name'], [
            ['Austrian cuisine'],
            ['Czech cuisine'],
            ['German cuisine'],
            ['Hungary cuisine'],
            ['Polish cuisine'],
            ['Liechtensteiner cuisine'],
            ['Slovak cuisine'],
            ['Slovenian cuisine'],
            ['Swiss cuisine'],
            ['Armenian cuisine'],
            ['Azerbaijani cuisine'],
            ['Belarusian cuisine'],
            ['Bulgarian cuisine'],
            ['Georgian cuisine'],
            ['Kazakh cuisine'],
            ['Moldovan cuisine'],
            ['Russian cuisine'],
            ['Mordovian cuisine'],
            ['Tatar cuisine'],
            ['Romanian cuisine'],
            ['Ukrainian cuisine'],
            ['Crimean Tatar cuisine'],
            ['British cuisine'],
            ['English cuisine'],
            ['Irish cuisine'],
            ['Scottish cuisine'],
            ['Welsh cuisine'],
            ['Danish cuisine'],
            ['Estonian cuisine'],
            ['Faroese cuisine'],
            ['Finnish cuisine'],
            ['Icelandic cuisine'],
            ['Irish cuisine'],
            ['Latvian cuisine'],
            ['Lithuanian cuisine'],
            ['Norwegian cuisine'],
            ['Sami cuisine'],
            ['Swedish cuisine'],
            ['Albanian cuisine'],
            ['Bosnia and Herzegovina cuisine'],
            ['Croatian cuisine'],
            ['Cypriot cuisine'],
            ['Northern Cypriot cuisine'],
            ['Gibraltarian cuisine'],
            ['Greek cuisine'],
            ['Italian cuisine'],
            ['Neapolitan cuisine'],
            ['Sardinian cuisine'],
            ['Sicilian cuisine'],
            ['Tuscan cuisine'],
            ['Venetian cuisine'],
            ['Macedonian cuisine'],
            ['Maltese cuisine'],
            ['Montenegrin cuisine'],
            ['Portuguese cuisine'],
            ['Sammarinese cuisine'],
            ['Serbian cuisine'],
            ['Kosovan cuisine'],
            ['Spanish cuisine'],
            ['Andalusian cuisine'],
            ['Asturian cuisine'],
            ['Aragonese cuisine'],
            ['Balearic cuisine'],
            ['Basque cuisine'],
            ['Canarian cuisine'],
            ['Cantabrian cuisine'],
            ['Castilian-Manchego cuisine'],
            ['Castilian-Leonese cuisine'],
            ['Catalan cuisine'],
            ['Extremaduran cuisine'],
            ['Galician cuisine'],
            ['Menorcan cuisine'],
            ['Valencian cuisine'],
            ['Turkish cuisine'],
            ['Belgian cuisine'],
            ['Dutch cuisine'],
            ['French cuisine'],
            ['Haute cuisine'],
            ['Cuisine classique'],
            ['Nouvelle cuisine'],
            ['Luxembourgian cuisine'],
            ['Monegasque cuisine'],
            ['Occitan cuisine'],
        ]);
    }

    public function down()
    {
        $this->dropTable('meal');
    }

}
