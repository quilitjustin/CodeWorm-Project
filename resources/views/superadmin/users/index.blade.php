@extends('layouts.user')

@section('content')
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">Users</h1>
							<p class="lead">
								List of worlds finest Procrastirnators
							</p>
						</div>
						<div class="card flex-fill">
							<div class="card-header">
								<h5 class="card-title mb-0">Ranking</h5>
							</div>
							<table class="table table-hover my-0">
								<thead>
									<tr>
										<th>id</th>
										<th class="d-none d-xl-table-cell">Name</th>
										<th class="d-none d-xl-table-cell">Status</th>
										<th class="d-none d-md-table-cell">Creation</th>
										<th class="d-none d-md-table-cell">Actions</th>
									</tr>
								</thead>
								<tbody>
									@forelse ($users as $user)
										<tr>
											<td>{{ $user['id'] }}</td>
											<td class="d-none d-xl-table-cell"><a href="{{ route('users.show', $user['id']) }}"></a>{{ $user['f_name'] . $user['l_name'] }}</a></td>
											<td><span class="badge bg-success">Active</span></td>
											<td class="d-none d-md-table-cell">{{ $user['created_at'] }}</td>
											<td class="d-none d-xl-table-cell">
												<a class="text-link" href="{{ route('users.show', $user['id']) }}">View</a>
												<a class="text-success" href="{{ route('users.edit', $user['id']) }}">Edit</a>
												<form class="d-inline" action="{{ route('users.destroy', $user['id']) }}" method="POST"
												onsubmit="return confirm('You are about to delete User ID: {{ $user['id'] }}s record. \n Are you sure?');">
													@csrf
													@method('DELETE')
													<button type="submit" class="text-danger">Delete</button>
												</form>
											</td>
										</tr>
									@empty
										<h5 class="text-center">No records</h5>
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
 </script>
@endsection
