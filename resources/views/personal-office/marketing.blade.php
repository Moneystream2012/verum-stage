@extends('layouts.personal-office')
@push('page-styles')
<style>
    td, th {
        text-align: center !important;
        vertical-align: middle !important;
        font-size: 16px;
    }
</style>
@endpush
@section('page')
    <div class="container-fluid-md">
        <div class="panel panel-default">
            <div class="panel-body">
                <h1 class="margin-horizontal text-center">Types of bonuses</h1>
                <div class="h3">
                    1. Direct Bonus <br>
                    2. Binary Bonus<br>
                    3. Matching Bonus<br>
                    4. Rewards
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <h3>Direct Bonus</h3>
                        <p>The bonus for the sale of the company's product (investment package), you will get % with
                            each purchase of the investment package under your reference, depending on your investment
                            package. Weekly payment.</p>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Package</th>
                                    <th>%</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{$product['name']}}</td>
                                        <td>{{$product['mlm_direct_bonus'] * 100}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h3>Binary Bonus</h3>
                        <p>This bonus is paid for developing two teams and it is accrued for sales in a smaller branch
                            every day. Percentage of payments depends on your investment package. Weekly payment.</p>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Package</th>
                                    <th>%</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{$product['name']}}</td>
                                        <td>{{$product['mlm_binary_bonus'] * 100}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <h3>Matching Bonus</h3>
                        <p>This is the percentage from checks of your personal partners up to 10 level, the percentage
                            of interest directly depends on your status in the company. Weekly payment.</p>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>1 Level</th>
                                    <th>2 L</th>
                                    <th>3 L</th>
                                    <th>4 L</th>
                                    <th>5 L</th>
                                    <th>6 L</th>
                                    <th>7 L</th>
                                    <th>8 L</th>
                                    <th>9 L</th>
                                    <th>10 L</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>TeamDeveloper</td>
                                    <td>10</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Director 1</td>
                                    <td>10</td>
                                    <td>10</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Director 2</td>
                                    <td>10</td>
                                    <td>10</td>
                                    <td>5</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Director 3</td>
                                    <td>10</td>
                                    <td>10</td>
                                    <td>5</td>
                                    <td>5</td>
                                    <td>5</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Director 4</td>
                                    <td>10</td>
                                    <td>10</td>
                                    <td>5</td>
                                    <td>5</td>
                                    <td>5</td>
                                    <td>5</td>
                                    <td>5</td>
                                    <td>5</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Director 5</td>
                                    <td>10</td>
                                    <td>10</td>
                                    <td>5</td>
                                    <td>5</td>
                                    <td>5</td>
                                    <td>5</td>
                                    <td>5</td>
                                    <td>5</td>
                                    <td>5</td>
                                    <td>5</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <h3>Ranks and Rewards</h3>
                        <p>This bonus is paid once, when reaching the volume in your smaller branch.</p>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Turnover of lower branch ($)</th>
                                    <th>Personal turnover ($)</th>
                                    <th>Additional conditions</th>
                                    <th>Reward ($)</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Director 1</td>
                                    <td>50 000</td>
                                    <td>5 000</td>
                                    <td>-</td>
                                    <td>1000</td>
                                </tr>
                                <tr>
                                    <td>Director 2</td>
                                    <td>100 000</td>
                                    <td>10 000</td>
                                    <td>-</td>
                                    <td>2 000</td>
                                </tr>
                                <tr>
                                    <td>Director 3</td>
                                    <td>500 000</td>
                                    <td>50 000</td>
                                    <td>-</td>
                                    <td>10 000</td>
                                </tr>
                                <tr>
                                    <td>Director 4</td>
                                    <td>1 000 000</td>
                                    <td>100 000</td>
                                    <td>-</td>
                                    <td>25 000</td>
                                </tr>
                                <tr>
                                    <td>Director 5</td>
                                    <td>3 000 000</td>
                                    <td>-</td>
                                    <td>2 x Director 4</td>
                                    <td>100 000</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
