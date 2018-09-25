<?php

namespace Drupal\Conferencias\Dao;

use Drupal\Core\Database\Database;

class FaqDao {

	static function getAll()
	{
        $conn = Database::getConnection();
        $result = $conn->query('select * from conferencias')->fetchAllAssoc('id');

		return $result;
	}

    /*static function getOne()
    {
        //$conn = Database::getConnection();
        //$result = $conn->query('select * from {faq}')->fe
        $result = db_query('select * from {faq}')->fetchAllAssoc('id');
        return $result;
    }*/

    static function exists($id) {
        $conn = Database::getConnection();
        $result = $conn->query('SELECT 1 FROM conferencias WHERE id = :id', array(':id' => $id))->fetchField();

        //$result = db_query('SELECT 1 FROM {faq} WHERE id = :id', array(':id' => $id))->fetchField();
        return (bool) $result;
    }

    static function add($titulo,$resumen,$fecha,$lugar,$hora) {
        $conn = Database::getConnection();
        $conn->insert('conferencias')->fields(
            array(
                'titulo' => $titulo,
                'resumen' => $resumen,
                'fecha'=>$fecha,
                'lugar'=>$lugar,
                'hora'=>$hora
            )
        )->execute();

    }

    static function update($id,$titulo,$resumen,$fecha,$lugar,$hora) {
        $conn = Database::getConnection();
        $conn->update('conferencias')->fields(
            array(
                'titulo' => $titulo,
                'resumen' => $resumen,
                'fecha'=>$fecha,
                'lugar'=>$lugar,
                'hora'=>$hora
            )
        )->condition('id', $id, '=')->execute();
        /*db_update('faq')
        ->fields(array(
          'question' => $question,
          'answare' => $answare,
        ))
        ->condition('id', $id, '=')
        ->execute();*/
    }

    static function delete($id) {
        //db_delete('faq')->condition('id', $id)->execute();
        $conn = Database::getConnection();
        $conn->delete('conferencias')->condition('id', $id, '=')->execute();

    }

}