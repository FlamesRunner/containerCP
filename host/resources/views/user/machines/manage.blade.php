@extends('layouts.app')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
@section('content')
<style>
	.td-label {
		text-align: right; background-color: #f9f9f9;
	}
</style>
<div class="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <span id="serverstatus">
                <span class="status-light sl-grey"><h1>Managing VM {{ $vm->id }} (CTID {{ json_decode(base64_decode($vm->properties))->ctid }})</h1></span>
            </span>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered table-responsive">
                <tbody>
                    <tr>
                        <td class="td-label">Memory Usage <span id="ramusage">(Refreshing...)</span></td>
                        <td style="">
                            <div class="progress" style="border-radius: 100px !important; width: 100%">
                                <div id="ram-bar" style="width: 0%;" class="progress-bar progress-bar-info" role="progressbar"></div>
                            </div> 
                        </td>
                    </tr>
                    <tr >
                        <td class="td-label">Disk <span id="diskusage">(Refreshing...)</span></td>
                        <td>
                            <div class="progress" style="border-radius: 100px !important">
                                <div id="disk-bar" style="width: 0%;" class="progress-bar progress-bar-info" role="progressbar"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-xs-6 td-label">Operating System</td>
                        <td id="os" class="col-xs-6">(please wait...)</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered table-responsive">
                <tbody>
                    <tr>
                        <td class="td-label">Node IP</td>
                        <td style="width: 90%">{{ $vm->node_ip }}</td>
                    </tr>
                <tr>
                    <td class="td-label">Assigned IP addresses</td>
                    <td id="assignedips">{{ $vm->host }}</td>
                </tr>
                <tr>
                    <td class="td-label">Virtualization</td>
                    <td>OpenVZ 7</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="container">
            <div class="row" style="padding-top: 20px">
                <div class="col-md-4" style="padding-top: 10px">
                    <div class="card">
                        <div class="card-body" style="padding-left: 15px; padding-top: 25px; padding-bottom: 18px; cursor: pointer;" id="start">
                            <center>
                                <h1><i style="color: #67e580;" class="fas fa-play"></i></h1>
                                Power on
                            </center>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" style="padding-top: 10px">
                    <div class="card">
                        <div class="card-body" style="padding-left: 15px; padding-top: 25px; padding-bottom: 18px; cursor: pointer;" id="stop">
                            <center>
                                <h1><i style="color: #ef3b32;" class="fas fa-stop"></i></h1>
                                Power off
                            </center>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" style="padding-top: 10px">
                    <div class="card">
                        <div class="card-body" style="padding-left: 15px; padding-top: 25px; padding-bottom: 18px; cursor: pointer;" id="restart">
                            <center>
                                <h1><i style="color: #99d0db;" class="fas fa-redo-alt"></i></h1>
                                Restart
                            </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container" style="padding-top: 40px">
        <div class="card">
            <div class="card-body">
                <h2>Settings</h2>
                <br />
                <h5><b>Kernel modules</b></h5>
                <div class="card">
                    <div class="card-body">
                        <b>TUN/TAP:</b> <span id="tun">(please wait)</span><br />
                        <b>User level quotas:</b> <span id="quota">(please wait)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function refresh() {
        $.get("{{ route('vm.data', [$vm->id]) }}", function(data) {
            var data_array = JSON.parse(data);
            $("#ram-bar").css('width', data_array[0] + "%");
            $("#ramusage").html("(" + data_array[1] + ")");
            if (data_array[2] == "Container is not running") {
                data_array[2] = "0";
            }
            $("#diskusage").html("(" + data_array[2] + "%)");
            $("#disk-bar").css('width', data_array[2] + "%");
            $("#tun").html(data_array[3]);
            $("#os").html(data_array[4]);
        });
    }
    setTimeout(refresh, 500);
    setInterval(refresh, 5000);
</script>

@endsection
