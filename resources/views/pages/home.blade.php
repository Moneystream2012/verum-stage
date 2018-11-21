@extends('layouts.default')
@section('title', $v_lang->title ?? null)
@section('description', $v_lang->description ?? null)
@section('scripts')
	{{--<script src="{{ asset('js/libs.js') }}"></script>--}}
	{{--<script src="{{ asset('js/main.js') }}"></script>--}}
@endsection
@section('styles')
	<link href="{{ mix('css/pages/home.css') }}" rel="stylesheet">
@endsection
@section('body')
	<header class="header">

		<div class="header__nav">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">

						<nav class="nav">
							<ul>
								<li><a href="#about">About</a></li>
								<li><a href="#services">Investment</a></li>
								<li><a href="#marketing">Marketing</a></li>
								<li><a href="#contacts">Contacts</a></li>
								<li><a href="#">Pdf</a></li>
							</ul>
						</nav>

					</div>
				</div>
			</div>

			<div class="header__main">
				<div class="header__logo">
					<picture>
						<source srcset="{{asset('img/logo-full-white.svg')}}" type="image/svg+xml"/>
						<img lass="logo-full" src="{{asset('img/logo-full.png')}}" calt="{{config('app.name')}}">
					</picture>
				</div>
				<h1>"The future is being created today"</h1>
				<div class="header__btn-group">
					<a href="{{route('personal-office.register')}}" class="btn btn-lg btn-white btn-line pull-left">Sign Up</a>
					<a href="{{route('personal-office.login')}}" class="btn btn-primary btn-lg pull-right">Login</a>
				</div>
			</div>
		</div>
		<div class="header__scroll_down">
			<picture>
				<source srcset="{{asset('img/pages/scroll-down.svg')}}" type="image/svg+xml"/>
				<img class="scroll_down" src="{{asset('img/scroll-down.png')}}" alt="scroll down">
			</picture>
		</div>
	</header>

	<section class="section" id="about">
		<header class="section__header">
			<div class="container">
				<h2>About</h2>
			</div>
		</header>
		<div class="section__content">
			<div class="container">
				<div class="row">
					<div class="col-xs-9">
						<p>
							The company Level Group Investment LTD was founded on August 24, 2016 and officially registed in Republic
							of Seychelles island! It is official investment company that takes investments from all physical and legal
							persons. Our activities we have sent on two large and profitable directions, such as Cryptocurrency and
							Alternative energy.</p>
						<p>We invest in servers of mining crypto currency BitCoin,Ethereum and of mining young and promising crypto
							currency.Also the Company is engaged in trading crypto currency exchanges.</p>
						<p>The next area its investing in startups associated with different types of alternative energy. There are
							wind generators and solar power,both local and global scales.
						</p>
					</div>
					<div class="col-xs-3">
						<div class="download-document">
							<a href="#">
								<picture>
									<source srcset="{{asset('img/pages/download-document.svg')}}" type="image/svg+xml"/>
									<img class="scroll_down" src="{{asset('img/pages/download-document.png')}}" alt="scroll down">
								</picture>
								<span class="more-text">(download official document)</span>
							</a>

						</div>
					</div>
				</div>

			</div>

		</div>
	</section>

	<section class="section" id="services">
		<header class="section__header">
			<div class="container">
				<h2>Investment</h2>
			</div>
		</header>
		<div class="section__content">
			<div class="container">
				<h3>Level Investments</h3>
				<p>Payments under the investments packages occur every 62 days during the one year. There are six payments in
					equal installments which includes the interest income and and the body of the income.</p>
				<br>

				<div style="overflow-x:auto;">
					<table>
						<tr>
							<th style="visibility:collapse;"></th>
							<th>Beginer</th>
							<th>Classic</th>
							<th>Professional</th>
							<th>Business</th>
							<th>Premium</th>
						</tr>
						<tr>
							<td>Price</td>
							<td>300.00 $</td>
							<td>1 000.00 $</td>
							<td>3 000.00 $</td>
							<td>5 000.00 $</td>
							<td>11 000.00 $</td>
						</tr>
						<tr>
							<td>Amount of</td>
							<td>66.50 $</td>
							<td>235.00 $</td>
							<td>710.00 $</td>
							<td>1 191.60 $</td>
							<td>2 640.00 $</td>
						</tr>
						<tr>
							<td>Number of</td>
							<td>6</td>
							<td>6</td>
							<td>6</td>
							<td>6</td>
							<td>6</td>
						</tr>
						<tr>
							<td>Time</td>
							<td>1 year</td>
							<td>1 year</td>
							<td>1 year</td>
							<td>1 year</td>
							<td>1 year</td>
						</tr>
						<tr>
							<td>Profit</td>
							<td>99.00 $</td>
							<td>410.00 $</td>
							<td>1 260.00 $</td>
							<td>2 149.60 $</td>
							<td>4 840.00 $</td>
						</tr>
						<tr class="footer-bottom">
							<td>&nbsp;</td>
							<td><a href="{{route('personal-office.register')}}" class="btn btn-primary">Sign Up</a></td>
							<td><a href="{{route('personal-office.register')}}" class="btn btn-primary">Sign Up</a></td>
							<td><a href="{{route('personal-office.register')}}" class="btn btn-primary">Sign Up</a></td>
							<td><a href="{{route('personal-office.register')}}" class="btn btn-primary">Sign Up</a></td>
							<td><a href="{{route('personal-office.register')}}" class="btn btn-primary">Sign Up</a></td>
						</tr>

					</table>
				</div>

				<hr>

				<h3>Level Shares</h3>
				<p>
					The Company allows the acquisition of its shares. (The Company gives you the opportunity to purchase their
					shares.)
					This is a long term investment in the company.
					The Company will sell 30% of the shares for all.
					Dividents are paid quarterly.
					The price of the first 10% of the shares(stock) is 5 $ per one share, next 10% is 7$ per one share and next
					10% is 10$ per one share.
					The sale of the shares occurs such parts: 10,25,50,100,250,500,1000 shares.
					The dividend amount is 0,1% to 6% and depends on the quarterly earnigs of the company.
					Divident payment starts after the full sale of the first 10% of the shares.
					For 5 years the Investor can sell their shares back to the company but with a commission of 30% of their
					value at the time of purchase.
				</p>



			</div>
		</div>
	</section>

	<section class="section" id="marketing">
		<header class="section__header">
			<div class="container">
				<h2>Marketing</h2>
				<p>For the development of our company ,we use both linear and binary marketing.</p>
				<p>Activation of your personal account <span class="regular">44$</span> is paid every year.</p>
			</div>
		</header>
		<div class="section__content">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<h3>Binary bonus:</h3>
						<p>4% of turnover in the lower leg. <br>
							Charged once a week on Tuesday. <br>
							Shares give the turnover points that reach 70 % of their value. <br>
							Each package has certain number of points in turnover.
						</p>
						<small>* CV - points</small>
					</div>

					<div class="col-sm-6">
						<br>
						<div style="overflow-x:auto;">
							<table>
								<tr>
									<td>Beginer</td>
									<td>100 CV</td>
								</tr>
								<tr>
									<td>Classic</td>
									<td>400 CV</td>
								</tr>
								<tr>
									<td>Professional</td>
									<td>1 200 CV</td>
								</tr>
								<tr>
									<td>Business</td>
									<td>2 000 CV</td>
								</tr>
								<tr>
									<td>Premium</td>
									<td>5 000 CV</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<hr>
				<h3>Refferal bonus:</h3>
				<p>The opening lines depends on the the status of the partner.</p>
				<br>
				<div style="overflow-x:auto;">
					<table>
						<thead>
						<tr>
							<th>Status</th>
							<th>1 line</th>
							<th>2 line</th>
							<th>3 line</th>
							<th>4 line</th>
							<th>5 line</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td>Partner</td>
							<td>4%</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr>
							<td>Manager</td>
							<td>4%</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr>
							<td>Regional Manager</td>
							<td>4%</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr>
							<td>Director</td>
							<td>4%</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr>
							<td>Regional Director</td>
							<td>4%</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr>
							<td>Platinum Director</td>
							<td>4%</td>
							<td>0.5%</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr>
							<td>Sapphire Director</td>
							<td>4%</td>
							<td>0.5%</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr>
							<td>Emerald Director</td>
							<td>4%</td>
							<td>0.5%</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr>
							<td>Diamond Director</td>
							<td>4%</td>
							<td>0.5%</td>
							<td>0.5%</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr>
							<td>President</td>
							<td>4%</td>
							<td>0.5%</td>
							<td>0.5%</td>
							<td>0.5%</td>
							<td>-</td>
						</tr>
						<tr>
							<td>Monarch</td>
							<td>4%</td>
							<td>0.5%</td>
							<td>0.5%</td>
							<td>0.5%</td>
							<td>-</td>
						</tr>
						<tr>
							<td>President Monarch</td>
							<td>4%</td>
							<td>0.5%</td>
							<td>0.5%</td>
							<td>0.5%</td>
							<td>0.5%</td>
						</tr>

						</tbody>
					</table>
				</div>
				<hr noshade>
				<h3>Status and Awards bonus:</h3>
				<p>
					* 50% of investments in the left team, 50% of investments in the right team <br>
					** One personally invited partner from right and left branches <br>
					*** Two personally invited partners in the sponsored and one partner in own branch.
				</p>
				<div style="overflow-x:auto;">
					<br>
					<table>
						<thead>
						<tr>
							<th>Status</th>
							<th>Turnover</th>
							<th>Line *</th>
							<th>Premium</th>
							<th>Personally Invited</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td>Partner</td>
							<td>5 000$</td>
							<td>1</td>
							<td>100$</td>
							<td>-</td>
						</tr>
						<tr>
							<td>Manager</td>
							<td>15 000$</td>
							<td>1</td>
							<td>200$</td>
							<td>-</td>
						</tr>
						<tr>
							<td>Regional Manager</td>
							<td>40 000$</td>
							<td>1</td>
							<td>500$</td>
							<td>-</td>
						</tr>
						<tr>
							<td>Director</td>
							<td>75 000$</td>
							<td>1</td>
							<td>1 000$</td>
							<td>-</td>
						</tr>
						<tr>
							<td>Regional Director</td>
							<td>150 000$</td>
							<td>1</td>
							<td>2 000$</td>
							<td>-</td>
						</tr>
						<tr>
							<td>Platinum Director</td>
							<td>350 000$</td>
							<td>1, 2</td>
							<td>5 000$</td>
							<td>2 X Regional Director **</td>
						</tr>
						<tr>
							<td>Sapphire Director</td>
							<td>500 000$</td>
							<td>1, 2</td>
							<td>10 000$</td>
							<td>2 X Platinum Director **</td>
						</tr>
						<tr>
							<td>Emerald Director</td>
							<td>1 000 000$</td>
							<td>1, 2</td>
							<td>20 000$</td>
							<td>3 X Sapphire Director **</td>
						</tr>
						<tr>
							<td>Diamond Director</td>
							<td>3 000 000$</td>
							<td>1, 2, 3</td>
							<td>50 000$</td>
							<td>3 X Emerald Director ***</td>
						</tr>
						<tr>
							<td>President</td>
							<td>
								1 000 000$ <br>
								5 000 000$
							</td>
							<td>
								1 <br>
								2, 3, 4
							</td>
							<td>100 000$</td>
							<td>3 X Diamond Director ***</td>
						</tr>
						<tr>
							<td>Monarch</td>
							<td>
								2 000 000$ <br>
								10 000 000$
							</td>
							<td>
								1 <br>
								2, 3, 4
							</td>
							<td>200 000$</td>
							<td>3 X President ***</td>
						</tr>
						<tr>
							<td>President Monarch</td>
							<td>
								3 000 000$ <br>
								15 000 000$
							</td>
							<td>
								1 <br>
								2, 3, 4, 5
							</td>
							<td>500 000$</td>
							<td>
								2 X President ** <br>
								2 X Monarch **
							</td>
						</tr>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>

	<section class="section" id="contacts">
		<header class="section__header">
			<div class="container">
				<h2>Contacts</h2>
			</div>
		</header>
		<div class="section__content">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<h4>Legal address:</h4>
						<address>
							<p>Suite 1 ,Second Floor, Sound & Vision House, Francis Rachel str. ,Mahe , Victoria , Seyshelles</p>
						</address>
						<br>
						<h4>E-Mail:</h4>
						<a href="mailto:support@levelgroup.com">support@levelgroup.com</a>
					</div>
					<div class="col-sm-6">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4032.34709935533!2d55.449976624287785!3d-4.623930763169412!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x22e029abf10225a5%3A0x8d8ae1ec0439af19!2sSound+and+Vision!5e0!3m2!1sru!2sua!4v1489896582890" width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>
					</div>
				</div>
			</div>

		</div>

	</section>

	<footer class="footer">
		<div class="container">
			<div class="row">
				<div class="col-md-7">
					<div class="footer__nav">
						<nav class="nav">
							<ul>
								<li><a href="#about">About</a></li>
								<li><a href="#services">Investment</a></li>
								<li><a href="#marketing">Marketing</a></li>
								<li><a href="#contacts">Contacts</a></li>
								<li><a href="#">Pdf</a></li>
							</ul>
						</nav>
					</div>
				</div>
				<div class="col-md-5">
					<div class="footer__copyright">
						<p>&copy; 2016 {{config('app.name')}}.biz
						<p>
					</div>
				</div>
			</div>
		</div>
	</footer>
@endsection
