@extends('templates.template')

@section('content')
    <h1 class="text-center">Listagem de Usu&aacute;rios</h1>
    <hr/>
    <div class="col-8 m-auto">
        <table class="table">
        <thead class="thead-dark">
            <tr>
            <th scope="col">Id</th>
            <th scope="col">Nome</th>
            <th scope="col">CPF/CNPJ</th>
            <th scope="col">Tipo</th>
            <th scope="col">Saldo</th>
            <th scope="col">E-mail</th>
            <th scope="col">Criado em</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                @php
                    $account=$user->find($user->id)->relAccount;
                    $type=$user->find($user->id)->type;
                @endphp
                <tr>
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->name}} {{$user->surname}}</td>
                    <td>{{$user->cpf_cnpj}}</td>
                    <td>{{$type->description}}</td>
                    <th >{{'R$ '.number_format($account->balance, 2, ',', '.')}}</th>
                    <td>{{$user->email}}</td>
                    <td>{{date( 'd/m/Y' , strtotime($user->created_at))}}</td>
                </tr>
            @endforeach
        </tbody>
        </table>
@endsection