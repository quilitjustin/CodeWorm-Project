@extends('layouts.app')

@section('content')
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">Leaderboards</h1>
							<p class="lead">
								The worlds finest Procrastirnators
							</p>
						</div>
						<div class="card flex-fill">
							<div class="card-header">
								<h5 class="card-title mb-0">Ranking</h5>
							</div>
							<table class="table table-hover my-0">
								<thead>
									<tr>
										<th>Rank</th>
										<th class="d-none d-xl-table-cell">Name</th>
										<th class="d-none d-xl-table-cell">Flex</th>
										<th class="d-none d-md-table-cell">Level</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>1</td>
										<td class="d-none d-xl-table-cell">John Dope</td>
										<td><span class="badge bg-success">I'm supreme!</span></td>
										<td class="d-none d-md-table-cell">9000</td>
									</tr>
								</tbody>
							</table>
						</div>
						<a href="/" class="text-link">&#x25c0; Go back</a>
					</div>
				</div>
			</div>
		</div>
	</main>
@endsection

@section('scripts')
 <script>
	// Code Goes here	
 </script>
@endsection
