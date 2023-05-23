@extends('layouts.web.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper"
        style="background-image: url('{{ asset('assets/bgim/help.png') . '?v=' . filemtime(public_path('assets/bgim/announcement.png')) }}'); background-repeat: no-repeat; background-position: center; background-attachment: fixed; background-size: cover;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-navy font-weight-bold">How to Play</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        {{-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('announcements.index') }}">Announcements</a></li>
                        <li class="breadcrumb-item active">Index</li>
                    </ol> --}}
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-navy">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Details
                                </h3>
                            </div>
                            <div class="card-body">
                                <p>
                                    <b>Introduction:</b><br>
                                    Welcome to Codeworm! an exciting adventure that will test your skills and immerse you
                                    in a thrilling virtual world. Prepare yourself for an epic journey filled with
                                    challenges, mysteries, and endless fun. Are you ready to embark on this unforgettable
                                    adventure?
                                </p>
                                <p>
                                    <b>How to Play:</b><br>
                                    <ol>
                                        <li>Select play from the sidebar on the left side or Click <a href="{{ route('web.play.index') }}" target="_blank">here</a>.</li>
                                        <li>Select programming language you wish to challenge. For example here we want to challenge PHP.
                                            <br>
                                            <img src="{{ asset('assets/help/h1.png') }}" alt="" style="max-width: 800px">
                                        </li>
                                        <li>Select stage For example here we want to challenge Stage 1.
                                            <br>
                                            <img src="{{ asset('assets/help/h2.png') }}" alt="" style="max-width: 800px">
                                        </li>
                                        <li>Click start button
                                            <br>
                                            <img src="{{ asset('assets/help/h3.png') }}" alt="" style="max-width: 800px">
                                        </li>
                                        <li>On the top left and top right corners, you'll be able to see your own and the enemy's details.
                                            <br>
                                            <img src="{{ asset('assets/help/h4.png') }}" alt="" style="max-width: 800px">
                                        </li>
                                        <li>In the bottom left corner, you'll be able to see your available skills that can be used to attack at the cost of SP, as well as the pause menu.
                                            <br>
                                            <img src="{{ asset('assets/help/h5.png') }}" alt="" style="max-width: 800px">
                                        </li>
                                        <li>What's in the middle are various tasks that you can choose and complete to gain SP. You can make your selection by clicking on them.
                                            <br>
                                            <img src="{{ asset('assets/help/h6.png') }}" alt="" style="max-width: 800px">
                                        </li>
                                        <li>Once you choose a task, you'll be able to see the description and examples provided to aid you in completing it.
                                            <br>
                                            <img src="{{ asset('assets/help/h7.png') }}" alt="" style="max-width: 800px">
                                        </li>
                                        <li>After gaining an understanding from the description and examples, you can click the Start Coding button to open your code editor and initiate the timer for the task. However, there's no need to worry as the timer only tracks how quickly you can complete the stage and doesn't impose any penalties. Of course, if needed, you can go back and review the description and examples by clicking the Description button.
                                            <br>
                                            <img src="{{ asset('assets/help/h8.png') }}" alt="" style="max-width: 800px">
                                        </li>
                                        <li>When you are confident with your answer, you can submit it using the Submit button, and you'll be able to see the output of your code in the console located in the bottom left corner. If your answer is correct, you'll gain SP. However, if you answer incorrectly, the enemy will attack.
                                            <br>
                                            <img src="{{ asset('assets/help/h9.png') }}" alt="" style="max-width: 800px">
                                        </li>
                                        <li>If you ever get tired or want to modify your settings, you can click on the Pause/Menu button.
                                            <br>
                                            <img src="{{ asset('assets/help/h10.png') }}" alt="" style="max-width: 800px">
                                        </li>
                                        <li>When clicking the quit button, it will first ask you if you really want to quit the game.
                                            <br>
                                            <img src="{{ asset('assets/help/h11.png') }}" alt="" style="max-width: 800px">
                                        </li>
                                        <li>When clicking the restart button, it will first ask you if you really want to restart the game.
                                            <br>
                                            <img src="{{ asset('assets/help/h12.png') }}" alt="" style="max-width: 800px">
                                        </li>
                                        <li>The moment you win, a popup will appear displaying your total time along with any rewards you may have earned. You will have the option to try again to improve your time, quit, proceed to the next stage (if available), or access the leaderboards (if no more stages are available).
                                            <br>
                                            <img src="{{ asset('assets/help/h13.png') }}" alt="" style="max-width: 800px">
                                        </li>
                                    </ol>
                                </p>
                                <p>
                                    <b>How stage time being calculated?</b><br>
                                    Your stage time will depend on how quickly you can finish each task within the stage. For example, if you spend 4 seconds on one task and another 4 seconds on another task, your total stage time would be 8 seconds.
                                </p>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
