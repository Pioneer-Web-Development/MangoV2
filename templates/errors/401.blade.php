@extends('template.master')

@section('content')
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <div class="row">
                <div class="col-sm-12">
                    <div class="text-center error-box">
                        <h1 class="error-text tada animated"><i class="fa fa-times-circle text-danger error-icon-shadow"></i> Error 401</h1>
                        <h2 class="font-xl"><strong>You do not have access to this resource!</strong></h2>
                        <br />
                        <p class="lead semi-bold">
                            <strong>According to your permissions, you cannot access this feature.</strong><br><br>
                            <small>
                               If you feel that you should have access, please speak with your local Mango Administrator.
                            </small>
                        </p>
                        <ul class="error-search text-left font-md">
                            <li><a href="/dashboard"><small>Go to Dashboard <i class="fa fa-arrow-right"></i></small></a></li>
                        </ul>
                    </div>

                </div>

            </div>

        </div>
    </div>
@endsection