@extends('backpack::layouts.plain')

@section('after_styles')
    <style>
        .error_number {
            font-size: 156px;
            font-weight: 600;
            line-height: 100px;
        }

        .error_number small {
            font-size: 56px;
            font-weight: 700;
        }

        .error_number hr {
            margin-top: 60px;
            margin-bottom: 0;
            width: 50px;
        }

        .error_title {
            margin-top: 40px;
            font-size: 36px;
            font-weight: 400;
        }

        .error_description {
            font-size: 24px;
            font-weight: 400;
        }

        .text-muted.ml-auto.mr-auto {
            display: none;
        }

        .button-primary {
            background-color: #329bd2;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 text-center">
                <div class="error_number">
                    <h2 style="font-weight: 500;">
                        This plugin licence is used on the
                        <i style="font-weight: bold;">{{ $activatedDomain }}</i> domain. <br>
                        Do you want to deactivate
                        <i style="font-weight: bold;">{{ $activatedDomain }}</i> and activate plugin on
                        <i style="font-weight: bold;">{{ $newDomain }}</i>?
                    </h2>
                </div>
                <div class="error_description text-muted">
                    <button><a href="{{ route('domain/re-activate', [
                                    'old_domain' => $activatedDomain,
                                    'new_domain' => $newDomain])
                                    }}">
                            Yes I do!</a></button>
                </div>
        </div>
    </div>
@endsection
