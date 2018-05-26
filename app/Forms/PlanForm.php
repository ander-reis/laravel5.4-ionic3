<?php

namespace CodeFlix\Forms;

//use CodeFlix\Models\PayPalWebProfile;
use CodeFlix\Models\Plan;
use Kris\LaravelFormBuilder\Form;

class PlanForm extends Form
{
    public function buildForm()
    {
        $durations = [
            Plan::DURATION_MONTHLY => 'Mensal',
            Plan::DURATION_YEARLY => 'Anual'
        ];

        $this
            ->add('duration', 'select', [
                'choices' => $durations,
                'rules' => 'required|in:' . implode(',', array_keys($durations))
            ])
//            ->add('paypal_web_profile_id', 'entity', [
//                'class' => PayPalWebProfile::class,
//                'property' => 'name',
//                'empty_value' => 'Selecione o perfil PayPal',
//                'label' => 'Perfil Web PayPal',
//                'rules' => 'required|exists:paypal_web_profiles,id'
//            ])
            ->add('name', 'text', [
                'rules' => 'required|max:255'
            ])
            ->add('description', 'text', [
                'rules' => 'required|max:255'
            ])
            ->add('value', 'text', [
                'rules' => 'required|numeric'
            ]);
    }
}