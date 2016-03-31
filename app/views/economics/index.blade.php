@extends('layout/application')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4>Total Money Being Printed (daily)</h4>
                </div>
                <div class="panel-body">
                    <div id="cashPrinted" style="height: 290px"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <a class="info-tiles tiles-green" href="#">
                <div class="tiles-heading">
                    <div class="pull-left">Total Printed Money</div>
                    <div class="pull-right">{{$increasePercent}}%</div>
                </div>
                <div class="tiles-body">
                    <div class="pull-left"><i class="fa fa-money"></i></div>
                    <div class="pull-right">${{Gliee\Irresistible\Utils::humanNumberFormat($totalCash)}}</div>
                </div>
            </a>
        </div>


        <div class="col-lg-3 col-md-6 col-sm-6">
            <a class="info-tiles tiles-primary" href="#">
                <div class="tiles-heading">
                    <div class="pull-left">Tax Rate</div>
                </div>
                <div class="tiles-body">
                    <div class="pull-left"><i class="fa fa-dollar"></i></div>
                    <div class="pull-right">{{$taxRate}}</div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6">
            <a class="info-tiles tiles-inverse" href="#">
                <div class="tiles-heading">
                    <div class="pull-left">Total Server Vehicles</div>
                </div>
                <div class="tiles-body">
                    <div class="pull-left"><i class="fa fa-truck"></i></div>
                    <div class="pull-right">{{$totalVehicles}}</div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6">
            <a class="info-tiles tiles-indigo" href="#">
                <div class="tiles-heading">
                    <div class="pull-left">Total Server Houses</div>
                </div>
                <div class="tiles-body">
                    <div class="pull-left"><i class="fa fa-home"></i></div>
                    <div class="pull-right">{{$totalHouses}}</div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <a class="info-tiles tiles-success" href="#">
                <div class="tiles-heading">
                    <div class="pull-left">Estimated Net Worth</div>
                </div>
                <div class="tiles-body">
                    <div class="pull-left"><i class="fa fa-user"></i></div>
                    <div class="pull-right">${{Gliee\Irresistible\Utils::humanNumberFormat($netWorth)}}</div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <a class="info-tiles tiles-brown" href="#">
                <div class="tiles-heading">
                    <div class="pull-left">User Capital</div>
                </div>
                <div class="tiles-body">
                    <div class="pull-left"><i class="fa fa-bar-chart-o"></i></div>
                    <div class="pull-right">${{Gliee\Irresistible\Utils::humanNumberFormat($userCapital)}}</div>
                </div>
            </a>
        </div>
    </div>

    <div ng-app="app" class="row">
        <div ng-controller="MainController" class="col-md-12">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <h4>Recent Offshore Wire Transfers</h4>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Wire Hash</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody ng-init="getMore()">
                            <tr ng-repeat="key in items" ng-class-odd="'odd gradeX'">
                                <td><% key.hash %></td>
                                <td>$<% key.cash %></td>
                                <td><% key.date %></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('jscontent')
<script type='text/javascript' src='{{URL::to('/')}}/assets/plugins/charts-flot/jquery.flot.min.js'></script> 
<script type='text/javascript' src='{{URL::to('/')}}/assets/plugins/charts-flot/jquery.flot.resize.min.js'></script>
<script type='text/javascript' src='{{URL::to('/')}}/assets/plugins/charts-flot/jquery.flot.time.min.js'></script> 
<script type="text/javascript" src="{{URL::to('/')}}/assets/js/angular.min.js"></script>
<script type='text/javascript' src='{{URL::to('/')}}/assets/js/flotgraph.js'></script>
<script type='text/javascript' src='{{URL::to('/')}}/assets/js/angularlive.js'></script>
@stop