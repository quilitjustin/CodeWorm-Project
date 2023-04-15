@extends('layouts.app')

@section('content')
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">
						<div class="col-sm-6">
							<button onclick="history.back();" class="text-info"><i class="right fas fa-angle-left"></i> Go Back</button>
						</div><!-- /.col -->
						<div class="text-center mt-4">
							<h1 class="h2">Leaderboards</h1>
							<p class="lead">
								The worlds finest Procrastirnators
							</p>
						</div>
						<div class="card flex-fill">
							<div class="card-header">
								<h5 class="card-title mb-0">Top 100</h5>
							</div>
							<table id="rank-tbl" class="table table-hover my-0">
								<thead>
									<tr>
										<th>Rank</th>
										<th class="d-none d-xl-table-cell">Name</th>
										<th class="d-none d-xl-table-cell">Language</th>
										<th class="d-none d-xl-table-cell">Stage</th>
										<th class="d-none d-md-table-cell">Time</th>
									</tr>
								</thead>
								<tbody>
									@forelse ($records as $record)
										<tr data-href="{{ route('public_profile.index', $record->id) }}">
											<td>{{ $loop->index +  1 }}</td>
											<td class="d-none d-xl-table-cell">{{ $record->f_name . $record->l_name }}</td>
											<td><span class="badge bg-success">I'm supreme!</span></td>
											<td><span class="badge bg-success">I'm supreme!</span></td>
											<td class="d-none d-md-table-cell">{{ $record->record }}</td>
										</tr>
									@empty
										<h5>No Records</h5>
									@endforelse
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
	$("#rank-tbl tr").click(function(){
		window.location = $(this).data('href');
	});
 </script>
@endsection
