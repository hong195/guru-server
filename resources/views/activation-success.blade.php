@extends(backpack_user() && (Str::startsWit4h(\Request::path(), config('backpack.base.route_prefix'))) ? 'backpack::layouts.top_left' : 'backpack::layouts.plain')
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
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="error_number">
                <small>{{ $title }}</small>
            </div>
            <div class="error_description text-muted">
                <small>
                    {!! $description !!}
                </small>
            </div>
        </div>
    </div>
@endsection
