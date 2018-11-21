@extends('layouts.administrator')
@section('title', 'Settings')
@section('page')
    <div class="container-fluid-md">
        <div class="panel panel-default">
            <div class="panel-heading">
                <p class="panel-title">Site</p>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="control-label col-sm-4" style="margin-top: 9px">Site Enable/Disable:</label>
                    <div class="col-sm-8">
                        <select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);" class="form-control">
                            <option value="{{route('administrator.settings.up')}}" @if(!$checkDown) selected @else @endif>Enable</option>
                            <option value="{{route('administrator.settings.down')}}" @if($checkDown) selected @else @endif>Disable</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

