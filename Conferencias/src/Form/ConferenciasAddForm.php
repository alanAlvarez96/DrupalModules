<?php
/**
 * Created by PhpStorm.
 * User: alan
 * Date: 24/09/18
 * Time: 19:34
 */
namespace Drupal\Conferencias\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Html;
use Drupal\Conferencias\Dao\FaqDao;
class ConferenciasAddForm extends FormBase
{
    function getFormID(){
        return 'bd_conferencias_add2';
    }
    function buildForm(array $form, FormStateInterface $form_state, $extra=null){
        $form['titulo']=array(
          '#type'=>'textfield',
          '#title'=> t('Titulo')
        );
        $form['resumen']=array(
          '#type'=>'textarea',
          '#title'=> t('Resumen')
        );
        $form['fecha']=array(
          '#type'=>'textfield',
          '#title'=> t('Fecha')
        );
        $form['lugar']=array(
          '#type'=>'textfield',
          '#title'=> t('Lugar')
        );
        $form['hora']=array(
          '#type'=>'textfield',
          '#title'=> t('Hora')
        );
        $form['actions'] = array('#type' => 'actions');
        $form['actions']['submit'] = array(
            '#type' => 'submit',
            '#value' => t('Agregar'),
        );
        $form['actions']['cancel'] = array(
            '#type' => 'submit',
            '#value' => t('Cancel'),
        );
        return $form;
    }
    function validateForm(array &$form, FormStateInterface $form_state) {

        $input = $form_state->getUserInput();

        if (isset($input['op']) && $input['op'] === 'Cancel') {
            return;
        }

        if (strlen($form_state->getValue('titulo')) <= 0) {
            $form_state->setErrorByName('titulo', $this->t('ingrese un titulo'));
        }
        if (strlen($form_state->getValue('resumen')) <= 0) {
            $form_state->setErrorByName('resumen', $this->t('ingrese un resumen'));
        }
        if (strlen($form_state->getValue('fecha')) <= 0) {
            $form_state->setErrorByName('fecha', $this->t('ingrese una fecha'));
        }
        if (strlen($form_state->getValue('lugar')) <= 0) {
            $form_state->setErrorByName('lugar', $this->t('ingrese un lugar'));
        }
        if (strlen($form_state->getValue('hora')) <= 0) {
            $form_state->setErrorByName('hora', $this->t('ingrese una hora'));
        }

    }
    function submitForm(array &$form, FormStateInterface $form_state){
        $input=$form_state->getUserInput();
        if (isset($input['op']) && $input['op'] === 'Cancel') {
            $form_state->setRedirect('ConfList');
            return;
        }
        $titulo=$form_state->getValue('titulo');
        $resumen=$form_state->getValue('resumen');
        $fecha=$form_state->getValue('fecha');
        $lugar=$form_state->getValue('lugar');
        $hora=$form_state->getValue('hora');
        FaqDao::add(Html::escape($titulo), Html::escape($resumen),Html::escape($fecha),
            Html::escape($lugar),Html::escape($hora));
        drupal_set_message(t('Conferencia agregada'));
        $form_state->setRedirect('ConfList');
        return;
    }
}