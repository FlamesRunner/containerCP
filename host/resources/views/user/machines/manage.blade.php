@extends('layouts.app')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <span id="serverstatus">
                <span class="status-light sl-grey"><h1>Managing VM {{ $vm->id }}</h1></span>
            </span>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered table-responsive">
                <tbody>
                    <tr>
                        <td style="text-align: right; background-color: #f9f9f9;">RAM Usage <span id="ramusage">(Refreshing...)</span></td>
                        <td style="width: 60%">
                            <div class="progress">
                                <div id="ram-bar" style="width: 0%;" class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"></div>
                            </div> 
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right; background-color: #f9f9f9;">Disk Usage <span id="diskusage">(Refreshing...)</span></td>
                        <td>
                            <div class="progress">
                                <div id="disk-bar" style="width: 0%;" class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"></div>
                            </div>

                        </td>
                    </tr>
                    <tr>
                        <td class="col-xs-6" style="text-align: right; background-color: #f9f9f9; border">Operating System</td>
                        <td id="os" class="col-xs-6"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered table-responsive">
                <tbody>
                    <tr>
                        <td style="text-align: right; background-color: #f9f9f9;">Node IP</td>
                        <td style="width: 90%"></td>
                    </tr>
                <tr>
                    <td style="text-align: right; background-color: #f9f9f9;">Assigned IPs</td>
                    <td id="assignedips"></td>
                </tr>
                <tr>
                    <td style="text-align: right; background-color: #f9f9f9; border">Virtualisation</td>
                    <td>OpenVZ 7</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body" style="padding-left: 15px; padding-top: 5px; padding-bottom: 8px; cursor: pointer;" id="start">
                            <center>
                                <h1><span style="color: #67e580;" class="glyphicon glyphicon-play"></span></h1>
                            </center>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body" style="padding-left: 15px; padding-top: 5px; padding-bottom: 8px; cursor: pointer;" id="stop">
                            <center>
                                <h1><span style="color: #ef3b32;" class="glyphicon glyphicon-stop"></span></h1>
                            </center>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body" style="padding-left: 15px; padding-top: 5px; padding-bottom: 8px; cursor: pointer;" id="restart">
                            <center>
                                <h1><span style="color: #99d0db;" class="glyphicon glyphicon-repeat"></span></h1>
                            </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
