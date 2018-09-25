<?php

namespace Drupal\Conferencias\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Html;
use Drupal\Conferencias\Dao\FaqDao;

class ConferenciasUpdateForm extends FormBase
{

	protected $id;

	function getFormID() {
		return 'bd_faq_update';
	}

	function buildForm(array $form, FormStateInterface $form_state, $id = '') {
		$this->id = $id;
		$pregunta = db_query("SELECT * FROM {conferencias} WHERE id = :id", array(':id' => $id))->fetchObject();
        $form['titulo']=array(
            '#type'=>'textfield',
            '#title'=> t('Titulo'),
            '#default_value'=>$pregunta->titulo
        );
        $form['resumen']=array(
            '#type'=>'textarea',
            '#title'=> t('Resumen'),
            '#default_value'=>$pregunta->resumen
        );
        $form['fecha']=array(
            '#type'=>'textfield',
            '#title'=> t('Fecha'),
            '#default_value'=>$pregunta->fecha
        );
        $form['lugar']=array(
            '#type'=>'textfield',
            '#title'=> t('Lugar'),
            '#default_value'=>$pregunta->lugar
        );
        $form['hora']=array(
            '#type'=>'textfield',
            '#title'=> t('Hora'),
            '#default_value'=>$pregunta->hora
        );
		$form['actions'] = array('#type' => 'actions');
		$form['actions']['submit'] = array(
		  '#type' => 'submit',
		  '#value' => t('Guardar'),
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

	function submitForm(array &$form, FormStateInterface $form_state) {
        $titulo=$form_state->getValue('titulo');
        $resumen=$form_state->getValue('resumen');
        $fecha=$form_state->getValue('fecha');
        $lugar=$form_state->getValue('lugar');
        $hora=$form_state->getValue('hora');
		FaqDao::update($this->id, Html::escape($titulo), Html::escape($resumen),Html::escape($fecha),
            Html::escape($lugar),Html::escape($hora));

		drupal_set_message(t('Tu pregunta ha sido actualizada.'));
		$form_state->setRedirect('Conferencias');
		return;
	}
}