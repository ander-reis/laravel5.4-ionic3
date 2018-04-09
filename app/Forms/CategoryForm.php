<?php
namespace CodeFlix\Forms;

use Kris\LaravelFormBuilder\Form;

class CategoryForm extends Form
{
    public function buildForm()
    {
        $this->add('category', 'text', [
                'label' => 'Categoria',
                'rules' => "required|unique:categories"
            ]);
    }
}