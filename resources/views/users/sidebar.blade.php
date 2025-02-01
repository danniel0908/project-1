<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet'>

<div class="sidebar" id="sidebar">
        <div class="sidebar-image">
            <img src="{{asset('image/userlogo.jpg')}}" alt="Profile Picture" class="profile-pic">
            <p style="color: black">{{ $userInfo['applicantType'] }}</p>
        </div>
        <div class="sidebar-content" data-intro="This is your sidebar menu." data-step="1">
            <a href="{{ route('dashboard') }}" style="color: black;" data-intro="Navigate to your dashboard" data-step="2">
                <i class="fas fa-home"></i><span class="label">Dashboard</span>
            </a>
            
            <a href="{{route('users.profile')}}" style="color: black;" data-intro="Manage your profile settings" data-step="3">
                <i class="fas fa-user"></i><span class="label">Profile</span>
            </a>
            
            <a href="{{ route('users.services') }}" style="color: black;" data-intro="View and manage your services" data-step="4">
                <i class="fa-solid fa-pen-to-square"></i><span class="label">Services</span>
            </a>

            <a href="{{ route('tickets.index') }}" style="color: black;"><i class="fa-solid fa-message"></i></i></i><span class="label">Message</span></a>


            <a href="{{ route('logout') }}" style="color: black;" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i>    
            <span class="label">Logout</span>
                
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>