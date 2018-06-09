<?php

namespace CodeFlix\Http\Controllers\Admin;

use CodeFlix\Forms\PayPalWebProfileForm;
use CodeFlix\Models\PayPalWebProfile;
use CodeFlix\Repositories\PayPalWebProfileRepository;
use Illuminate\Http\Request;
use CodeFlix\Http\Controllers\Controller;
class PayPalWebProfilesController extends Controller
{
    /**
     * @var PayPalWebProfileRepository
     */
    private $repository;
    /**
     * PayPalWebProfilesController constructor.
     * @param PayPalWebProfileRepository $repository
     */
    public function __construct(PayPalWebProfileRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $webProfiles = $this->repository->paginate();
        return view('admin.webProfiles.index', compact('webProfiles'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = \FormBuilder::create(PayPalWebProfileForm::class, [
            'url' => route('admin.web_profiles.store'),
            'method' => 'POST'
        ]);
        return view('admin.webProfiles.create', compact('form'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form = \FormBuilder::create(PayPalWebProfileForm::class);
        if (!$form->isValid()){
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }
        $data = $form->getFieldValues();
        $this->repository->create(array_except($data,'code'));
        $request->session()->flash('message', 'Perfil PayPal criado com sucesso.');
        return redirect()->route('admin.web_profiles.index');
    }
    /**
     * Display the specified resource.
     *
     * @param PayPalWebProfile $web_profile
     * @return \Illuminate\Http\Response
     */
    public function show(PayPalWebProfile $web_profile)
    {
        return view('admin.webProfiles.show', compact('web_profile'));
    }
    /**
     * Show the form for editing the specified resource.
     * @param PayPalWebProfile $web_profile
     * @return \Illuminate\Http\Response
     */
    public function edit(PayPalWebProfile $web_profile)
    {
        $form =  \FormBuilder::create(PayPalWebProfileForm::class, [
            'url' => route('admin.web_profiles.update', ['web_profile' => $web_profile->id]),
            'method' => 'PUT',
            'model' => $web_profile
        ]);
        return view('admin.webProfiles.edit', compact('form'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $form = \FormBuilder::create(PayPalWebProfileForm::class);
        if (!$form->isValid()){
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }
        $data =  $form->getFieldValues();
        $this->repository->update($data, $id);
        $request->session()->flash('message', 'Perfil PayPal alterado com sucesso.');
        return redirect()->route('admin.web_profiles.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->repository->delete($id);
        $request->session()->flash('message', 'Perfil PayPal excluido com sucesso.');
        return redirect()->route('admin.web_profiles.index');
    }
}

