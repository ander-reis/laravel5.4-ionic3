<?php

namespace CodeFlix\Forms;

use Kris\LaravelFormBuilder\Form;

class SerieForm extends Form
{
    public function buildForm()
    {
        //retorna id
        $id = $this->getData('id');
        //regras do formulario
        $this
            ->add('title', 'text', [
                'label' => 'Título',
                'rules' => 'required|max:255'
            ])
            ->add('description', 'textarea', [
                'label' => 'Descrição',
                'rules' => 'required|max:255'
            ])
            ->add('thumb_file', 'file', [
                'required' => !$id ? true : false,
                'label' => 'Thumbnail',
                'rules' => 'image|max:1024'
            ]);
    }
}
