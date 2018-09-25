<?php
/**
 * Created by PhpStorm.
 * User: alan
 * Date: 23/09/18
 * Time: 15:01
 */
namespace Drupal\Conferencias\Controller;

use Drupal\Conferencias\Dao\FaqDao;
use Drupal\Core\Url;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Link;
use Drupal\Core\Render\RendererInterface;

class ConferenciasController extends ControllerBase{
    public function add(){
        $extra = '612-123-4567';
        $form = \Drupal::formBuilder()->getForm('Drupal\Conferencias\Form\ConferenciasAddForm', $extra);
        return array(
            '#title'   => 'Conferencias',
            '#type'    => 'markup',
            '#markup'  => RendererInterface::render($form),
        );
    }

    public function lista()
    {
        $new_link="";
        if(\Drupal::currentUser()->hasPermission('Conferencias add')) {
            echo "tengo permisos";
            $url = Url::fromRoute('Conferenciasadd');
            $link_options = array(
                'attributes' => array(
                    'class' => array(
                        'btn',
                        'btn-primary',
                    ),
                ),
            );
            $url->setOptions($link_options);
            $new_link = Link::fromTextAndUrl(t('Nuevo'), $url);
        }
        $header=array(
            'id'=>t('Id'),
            'titulo'=>t('Titulo'),
            'resumen'=>t('Resumen'),
            'fecha'=>t('Fecha'),
            'hora'=>t('Hora'),
            'lugar'=>t('Lugar'),
            'eliminar'=>t('Eliminar'),
            'actualizar'=>t('Actualizar'),
        );;
        $rows=array();
        foreach (FaqDao::getAll()as $id=>$content){
            $url=Url::fromRoute('ConferenciasDelete',['id'=>$content->id]);
            $delete_link=\Drupal::l(t('Eliminar'), $url);
            $url = Url::fromRoute('ConferenciasUpdate', ['id' => $content->id]);
            $update_link = \Drupal::l(t('Modificar'), $url);
            $rows[] = array(
                'data' => array($id, $content->titulo, $content->resumen,$content->fecha,
                $content->hora,$content->lugar
                , $delete_link, $update_link)
            );
            //var_dump($rows);
        }
        $table = array(
            '#type' => 'table',
            '#header' => $header,
            '#rows' => $rows,
            '#attributes' => array(
                'id' => 'bd-faq-table',
            ),
        );
        //echo "pase de la tabla";
        //var_dump($table);
        return array(
            '#title'=>'Conferencias hola ',
            '#theme'=> 'conf-list',
            '#new_Conf'=>$new_link,
            '#conf_list_table'=>\Drupal::service('renderer')->render($table),
        );
    }
}