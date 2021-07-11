@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
                    <form action="/">
                        <button class="btn btn-outline-dark"><- На главную</button>
                    </form>
                    <input type="button" class="btn btn-outline-success" onclick="history.forward();" value="Вперед ->"/>
                    <hr>
                </nav>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nickname</th>
                                <th>Real Name</th>
                                <th>Origin Description</th>
                                <th>Superpowers</th>
                                <th>Catch Phrase</th>
                            </tr>
                            </thead>
                            <tbody>
{{--                            @foreach($paginator ?? '' as $hero)--}}
                                @php
                                    /** @var App\Models\SuperHeroes $hero */
                                @endphp
                                <tr @if(isset($hero)) style="background-color: #ccc;" @endif>
                                    <td>{{ $hero->id }}</td>
                                    <td>{{ $hero->nickname }}</td>
                                    <td>{{ $hero->real_name }}</td>
                                    <td>{{ $hero->origin_description }}</td>
                                    <td>{{ $hero->superpowers }}</td>
                                    <td>{{ $hero->catch_phrase }}</td>
                                    <td>
                                    </td>
                                    <td>{{ $hero->created_at ? \Carbon\Carbon::parse($hero->created_at)->format('d M H:i') : '' }}</td>
                                    <td>{{ $hero->updated_at ? \Carbon\Carbon::parse($hero->updated_at)->format('d M H:i') : '' }}</td>
                                </tr>
{{--                            @endforeach--}}
                            </tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
