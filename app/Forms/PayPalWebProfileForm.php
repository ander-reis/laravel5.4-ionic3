<?php

namespace CodeFlix\Forms;

use Kris\LaravelFormBuilder\Form;

class PayPalWebProfileForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text',[
                'label' => 'Nome',
                'rules' => 'required|max:255'
            ])
            ->add('logo_url', 'text',[
                'label' => 'Logo Url',
                'rules' => 'required|max:255'
            ]);
    }
}
