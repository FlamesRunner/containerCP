<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use phpseclib\Net\SSH2;

class VMController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function get_resource_data($id) {
        if (\App\VM::where('owner', \Auth::id())->where('id', $id)->count() == 0) {
            return "access_denied";
        }

        $vm = \App\VM::where('owner', \Auth::id())->where('id', $id)->first();
        $node = \App\Node::where('id', $vm->node)->first();
        $ctid = json_decode(base64_decode($vm->properties))->ctid;

        $ssh = new SSH2($node->host);
        if (!$ssh->login('vm_manager', $node->apikey)) {
            return "connection_failed";
        }
        $format = 'sudo containermanager ';
        $output = $ssh->exec($format . 'memusage ' . $ctid . '; echo "\n"; ' . $format . 'rammb ' . $ctid . '; echo "\n"; ' . $format . 'diskusage ' . $ctid . '; echo "\n"; ' . $format . 'checktun ' . $ctid . '; echo "\n";' . $format . 'getos ' . $ctid);
        $ssh->disconnect();
        $output_array = explode('\n', $output);
        for ($i = 0; $i < count($output_array); $i++) {
            $output_array[$i] = trim($output_array[$i]);
            $output_array[$i] = trim($output_array[$i], ".");
        }
        return json_encode($output_array);
    }

    public function manage_index($ctid) {
        if (\App\VM::where('owner', \Auth::id())->where('id', $ctid)->count() == 0) {
            return redirect(route('vm.list'));
        }
        $vm = \App\VM::where('owner', \Auth::id())->where('id', $ctid)->first();
        $node = \App\Node::where('id', $vm->node)->first();
        $vm->node_ip = $node->host;
        return view('user.machines.manage')->with('vm', $vm);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $vms = \App\VM::where('owner', \Auth::id())->paginate(5);
        return view('user.machines.list')->with('vms', $vms);
    }
}
