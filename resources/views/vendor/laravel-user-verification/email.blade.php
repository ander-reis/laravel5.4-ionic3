
<h3>{{config('app.name')}}</h3>
<p>Sua copnta na plataforma foi criada</p>
<p>
    Clique
    <a href="{{ $link = route('email-verification.check', $user->verification_token) . '?email=' . urlencode($user->email) }}">
        Aqui
    </a>
    &nbsp;para verificar sua conta.
</p>
<p>Não responda esse e-mail, ele é gerado automaticamente</p>
