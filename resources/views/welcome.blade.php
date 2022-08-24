<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
    <meta charset="utf-8">
    <title>Landing Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('css/bootstrap-datepicker.css')}}" />
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>
<div class="wrapper">
  <div class="sidebar position-fixed h-100 bg-white"> <a href="#" class="logo-sidebar"><img src="{{asset('images/sidebarlogo.png')}}" alt=""></a>
    <ul class="sidebar-items">
      <li ><a href="#" class="active"><img src="{{asset('images/dashboard-1.png')}}" alt=""></a></li>
      <li><a href="#"><img src="{{asset('images/dashboard-2.png')}}" alt=""></a></li>
      <li><a href="#"><img src="{{asset('images/dashboard-3.png')}}" alt=""></a></li>
      <li><a href="#"><img src="{{asset('images/dashboard-4.png')}}" alt=""></a></li>
    </ul>
  </div>
  <section class="content-sec py-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="header-box d-flex justify-content-between align-items-center mb-4"> <img src="images/logo.svg" alt="">
            <div class="header-tagline bg-white py-3 px-3 w-100 text-center ml-4">
              <div class="progressbox"></div>
              <h1 class="font-20 font-weight-medium">Pekoe Mortgages www.pekoe.ca </h1>
            </div>
          </div>
          <div class="leaderboard bg-white p-4 mb-4">
            <div class="leaderboard-head d-flex justify-content-between align-items-center mb-2">
                <h3 class="font-25 font-weight-bold">Leaderboard</h3>
                <div class="dropdown">

                    <button class="btn btn-secondary dropdown-toggle font-14" type="button"
                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        {{$monthwise ? $monthwise : 'Select Date'}}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @foreach($mortageVolumnDates as $mortageVolumnDate)
                        <form action="{{ route('get-monthly-stats') }}" method="POST">
                            @csrf
                            <?php  $date=''; $date=date('F Y', strtotime($mortageVolumnDate->month)); ?>
                            <button class="dropdown-item" href="#">{{$date}}<input type="hidden"
                                    name="month" value="{{$mortageVolumnDate->month}}"></button>
                        </form>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col" class="font-12  px-0">RANKING</th>
                    <th scope="col" class="font-12 text-center px-0">NAME</th>
                    <th scope="col" class="font-12 text-center px-0">VOLUME</th>
                    <th scope="col" class="font-12  px-0">MONTHLY CHANGE</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($mortageVolumnTop as $key =>  $topVolumn)
                  <tr>
                    <td class=" font-weight-bold px-0"><div class="counter font-30 d-flex justify-content-center align-items-center">{{$key + 1}}</div></td>
                    <td class="text-center px-0 font-weight-bold"><div class="namepic d-flex align-items-center justify-content-center">
                        <div class="imgicon position-relative"> <img src="{{ asset('images/icon-img.png') }}" alt=""> <span class="online-status"></span> </div>
                        <h5 class="font-weight-bold font-20 ml-3">{{$topVolumn->full_name}}</h5>
                      </div></td>
                    <td class="text-center font-weight-bold px-0" >${{ $topVolumn->total_amount }}</td>
                    <td class="text-center font-weight-bold px-0"><div class="d-flex justify-content-end changenumber">+3 <img src="images/arrow-up.svg" alt="" class="ml-2"></div></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <div class="leaderboard bg-white p-4 mb-4 mortgage-board">
            <div class="leaderboard-head d-flex justify-content-between align-items-center mb-2">
              <h3 class="font-25 font-weight-bold">Mortgage Team</h3>
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle font-14" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Add Member </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1"> 
                  <button data-toggle="modal" data-target="#createmodal" class="dropdown-item create-btn">Add Member</button>
                  <a class="dropdown-item" href="#">Import Team</a> 
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table" id="teamMemberTable">
                <thead>
                  <tr>
                    <th scope="col" class="font-12  px-0">NAME</th>
                    <th scope="col" class="font-12 text-center px-0">EMAIL</th>
                    <th scope="col" class="font-12 text-center px-0">VOLUME</th>
                    <th scope="col" class="font-12  px-0">DETAILS</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($teamMembers as $key => $teamMember)
                    <tr>
                        <td class="text-center px-0 font-weight-bold font-15"><div class="namepic d-flex align-items-center ">
                            <div class="imgicon position-relative"> <img src="{{ asset('images/icon-img.png')}}" alt=""> <span class="online-status"></span> </div>
                            <h5 class="font-weight-bold font-15 ml-3">{{ $teamMember['full_name'] }}</h5>
                        </div></td>
                        <td class="text-center font-weight-medium px-0 email font-15" >{{ $teamMember['email'] }}</td>
                        
                        <?php
                            $motrageVolumn = $teamMember['mortageVolumns']->last();
                            if($motrageVolumn !=''){
                            $date=date_create($motrageVolumn ? $motrageVolumn['month'] : '');
                            $date = date_format($date,"F Y");
                            }else{
                              $date='--';
                            }
                        ?>
                        <td class="text-center font-weight-bold px-0 d-flex justify-content-center font-15" ><p class="mr-3">{{ $date }} </p>
                        <p>{{ $motrageVolumn ? '$'.$motrageVolumn['amount'] : '--' }}</p></td>
                        <td class=" font-weight-bold px-0" ><button data-id="{{$teamMember['id']}}" data-toggle="modal" data-target="#editmodal" class="edit-btn d-inline-flex justify-content-center align-items-center font-12">Edit</button></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <div class="footerbox d-flex justify-content-between align-items-center">
            <p class="font-14 font-weight-medium">Showing {{($teamMembers->currentPage() == 1 ) ? 1 : (($teamMembers->currentPage() - 1) * 10) + 1 }} to {{(($teamMembers->currentPage() - 1) * 10) + $teamMembers->count()}} of {{$teamMembers->total()}} entries</p>
            <nav aria-label="...">
              <ul class="pagination">
                <li class="page-item"> <a class="page-link prvpage bg-white {{$teamMembers->previousPageUrl() ? '' : 'disabled'}}" href="{{ $teamMembers->previousPageUrl() ?  route('team-member', ['page' => $teamMembers->currentPage() - 1 ]): 'javascript:void(0);' }}"><img src="images/left.svg" alt=""></a> </li>

                @if($teamMembers->lastPage() > 5)
                    <?php
                        $currentPage = $teamMembers->currentPage();
                        $totalPages = $teamMembers->lastPage();
                        $result = [];
                        if($totalPages <= 5) {
                            for($i = 1; $i <= $totalPages; $i++) {
                                array_push($result, $i);
                            }
                        } 
                        elseif($currentPage < 3){
                            for($i = 1; $i <=5; $i++){
                                array_push($result, $i);
                            }
                        }
                        elseif($currentPage + 2 > $totalPages) {
                            for($i = $totalPages; $i > $totalPages - 5; $i--){
                                array_unshift($result,$i);
                            }
                        } 
                        else{
                            for($i = $currentPage - 2; $i < $currentPage + 3; $i++) {
                                    array_push($result, $i);
                            }
                        }
                    ?>
                        @foreach($result as $page)
                            <li class="page-item {{ ($page == $currentPage) ? 'active' : '' }}">
                              <a class="page-link cursor-pointer" href="{{ ($page != $currentPage) ? route('team-member', ['page' => $page]) : 'javascript:void(0);' }}"> {{$page}} </a>
                            </li>
                        @endforeach
                    @else
                      @for($i = 1; $i <= $teamMembers->lastPage(); $i++)
                        <li class="page-item {{ ($i == $teamMembers->currentPage()) ? 'active' : '' }}">
                          <a class="page-link cursor-pointer" href="{{ ($i != $teamMembers->currentPage()) ? route('team-member', ['page' => $i]) : 'javascript:void(0);' }}"> {{$i}} </a>
                        </li>
                      @endfor
                    @endif
                <li class="page-item"> <a class="page-link prvpage bg-white {{$teamMembers->nextPageUrl() ? '' : 'disabled'}}" href="{{ $teamMembers->nextPageUrl() ?  route('team-member', ['page' => $teamMembers->currentPage() + 1 ]): 'javascript:void(0);' }}"><img src="images/right.svg" alt=""></a> </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <!--Edit Modal Start -->
  <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-15" id="exampleModalLongTitle">Edit Team Member</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
        </div>
          <form class="top-form mb-4" id="append-mortage-edit-form" action="{{ route('update-team-member') }}" method="POST">
      <input type="hidden" name="team_member_id" id="team_member_id"  value=""/>
        @csrf  
        <div class="modal-body">
            <div class="form-group">
              <label  class="font-12 font-weight-normal">Full Name:</label>
              <input type="text" class="form-control font-12 font-weight-normal" name="full_name" id="edit-full_name"  placeholder="Enter full name">
            </div>
            <div class="form-group">
              <label class="font-12 font-weight-normal">Email address:</label>
              <input type="email" class="form-control font-12 font-weight-normal" name="email" id="edit-email" placeholder="Enter email">
            </div>
          <div class="leaderboard-head d-flex justify-content-between align-items-center mb-2">
            <h3 class="font-15 font-weight-bold">Mortgage Volume</h3>
          </div>
          <table class="table volume-table">
            <thead>
              <tr>
                <th scope="col" class="font-12   text-left px-0">MONTH</th>
                <th scope="col" class="font-12 text-center px-0">AMOUNT</th>
                <th scope="col" class="font-12 text-right px-0">ACTION</th>
              </tr>
            </thead>
            <tbody id="append-mortage-edit-popup">
            </tbody>
          </table>
          <div class="row align-items-center">
            <div class="col-lg-5">
            <input type="text" class="form-control font-12 font-weight-normal update-mortage-date"  placeholder="Select Date" id="update-mortage-date" value="">
             </div>
            <div class="col-lg-5">
              <input type="text" class="form-control font-12 font-weight-normal"  placeholder="Enter Volume" id="update-mortage-volumn" value="">
            </div>
            <div class="col-lg-2">
              <button id="updateMortagebtn" class="savebtn d-flex justify-content-center align-items-center text-white">+ SAVE</button>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary font-12" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary font-12">Submit</button>
        </div>
         </form>
      </div>
     
    </div>
  </div>
  <!--Edit Modal End -->

  <!--Create Modal Start -->
  <div class="modal fade" id="createmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-15" id="exampleModalLongTitle">Create Team Member</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <form class="top-form mb-4" id="append-mortage-create-form"  action="{{ route('create-team-member') }}" method="POST">
      @csrf
      <div class="modal-body">
          <div class="form-group">
            <label  class="font-12 font-weight-normal">Full Name:</label>
            <input type="text" name="full_name" id="full_name" class="form-control font-12 font-weight-normal"  placeholder="Enter full name" value="">
          </div>
          <div class="form-group">
            <label class="font-12 font-weight-normal">Email address:</label>
            <input type="email" name="email" id="email" class="form-control font-12 font-weight-normal"  placeholder="Enter email" value="">
          </div>
        <div class="leaderboard-head d-flex justify-content-between align-items-center mb-2">
          <h3 class="font-15 font-weight-bold">Mortgage Volume</h3>
        </div>
        <table class="table volume-table">
          <thead>
            <tr>
              <th scope="col" class="font-12 text-left px-0">MONTH</th>
              <th scope="col" class="font-12 text-center px-0">AMOUNT</th>
              <th scope="col" class="font-12 text-right px-0">ACTION</th>
            </tr>
          </thead>
          <tbody id="append-mortage-create-popup">
          </tbody>
        </table>
        <div class="row align-items-center">
          <div class="col-lg-5">
            <input type="text" class="form-control font-12 font-weight-normal create-mortage-date"  placeholder="Select Date" id="create-mortage-date" value="">
          </div>
          <div class="col-lg-5">
            <input type="number" class="form-control font-12 font-weight-normal"  placeholder="Enter Volume" id="create-mortage-volumn" value="">
          </div>
          <div class="col-lg-2">
            <button id="saveMortagebtn" class="savebtn d-flex justify-content-center align-items-center text-white">+ SAVE</button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary font-12" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary font-12">Submit</button>
      </div>
      </form>
    </div>
    
  </div>
 
  <!--Create Modal End -->
</div>
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/bootstrap-datepicker.js')}}"></script>

<script>
  $( document ).ready(function() {
      $(".create-mortage-date").datepicker({
          format: "MM yyyy",
          viewMode: "years",
          minViewMode: "months"
      });
        $(".update-mortage-date").datepicker({
          format: "MM yyyy",
          viewMode: "years",
          minViewMode: "months"
      });
    $("#updateMortagebtn").click(function(event){
      event.preventDefault();
      var mortageDate = $("#update-mortage-date").val();
      var mortageVolumn = $("#update-mortage-volumn").val();
      if(!mortageDate || !mortageVolumn){
        alert('Incorrect Date & Amount!')
        return false;
      }
      $("#append-mortage-edit-popup").append("<tr><td class='font-12 text-left px-0 font-weight-medium'><input type='text' name='mortageDate[]' readOnly style='border:none;' value='"+mortageDate+"' /></td><td class='font-12 text-center px-0 font-weight-medium'> <input type='number' class='text-center' name='mortageVolumn[]' readOnly style='border:none;' value='"+mortageVolumn+"' /></td><td class='font-12 text-right px-0 font-weight-medium'><button class='border-0 bg-transparent btnDelete'><img src='images/trash.svg' alt='Delete Mortage'></button></td></tr>");
      $("#update-mortage-date").val("");
      $("#update-mortage-volumn").val("");
    });

    $("#saveMortagebtn").click(function(event){
      event.preventDefault();
      var mortageDate = $("#create-mortage-date").val();
      var mortageVolumn = $("#create-mortage-volumn").val();
      if(!mortageDate || !mortageVolumn){
        alert('Incorrect Date & Amount!')
        return false;
      }
      $("#append-mortage-create-popup").append("<tr><td class='font-12 text-left px-0 font-weight-medium'><input type='text' name='mortageDate[]' readOnly style='border:none;' value='"+mortageDate+"' /></td><td class='font-12 text-center px-0 font-weight-medium'> <input type='number' class='text-center' name='mortageVolumn[]' readOnly style='border:none;' value='"+mortageVolumn+"' /></td><td class='font-12 text-right px-0 font-weight-medium'><button class='border-0 bg-transparent btnDelete'><img src='images/trash.svg' alt='Delete Mortage'></button></td></tr>");
      $("#create-mortage-date").val("");
      $("#create-mortage-volumn").val("");
    });

    $("#append-mortage-create-popup").on('click', '.btnDelete', function () {
        $(this).closest('tr').remove();
    });

    $("#append-mortage-edit-popup").on('click', '.btnDelete', function () {
        $(this).closest('tr').remove();
    });

    $(".edit-btn").click(function(){
      var id = $(this).attr("data-id");
      $("#team_member_id").val(id);
      $.ajax({
          url: '/get-team-member-by-id/'+ id,
          type: 'GET',
          success: function(data) {
            $("#edit-full_name").val(data.full_name);
            $("#edit-email").val(data.email);
            if(data && data.mortage_volumns){
              $("#append-mortage-edit-popup").empty();
              $.each(data.mortage_volumns, function( index, value ) {
                $("#append-mortage-edit-popup").append("<tr><td class='font-12 text-left px-0 font-weight-medium'><input type='text' name='mortageDate[]' readOnly style='border:none;' value='"+value.month+"' /></td><td class='font-12 text-center px-0 font-weight-medium'> <input type='number' class='text-center' name='mortageVolumn[]' readOnly style='border:none;' value='"+value.amount+"' /></td><td class='font-12 text-right px-0 font-weight-medium'><button class='border-0 bg-transparent btnDelete'><img src='images/trash.svg' alt='Delete Mortage'></button></td></tr>");
              });
            }
          }
      });
    });
});
</script>
</body>
</html>
