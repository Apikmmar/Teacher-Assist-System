@php
    $user = auth()->user();
    $call = 'null';

    $call = ($user->gender === 'Men') ? 'Mr. ' : (($user->gender === 'Women') ? 'Mrs. ' : '');
@endphp

<<nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
    <div class="container-fluid h-100">
        <div class="d-flex justify-content-between align-items-center w-100">
            <div class="d-flex flex-grow-1">
                <p class="navbar-text fw-bold text-dark m-0">Sekolah Menengah Kebangsaan Baling</p>
            </div>
            <div class="d-flex align-items-center">
                <div class="dropdown me-4">
                    <a href="#" class="text-dark position-relative" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell fs-4"></i>
                        <span id="notification-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            0
                        </span>
                    </a>
                    <ul id="notification-dropdown" class="dropdown-menu dropdown-menu-end shadow">
                        <li><a class="dropdown-item text-muted">Loading...</a></li>
                    </ul>
                </div>
                
                <div>
                    <p class="m-0 me-2 fw-bold">{{ $call . $user->name }}</p>
                </div>
                <div class="me-4">
                    <a href="{{ route('profile.edit') }}">
                    @if (!empty($user->photo))
                        <img src="{{ asset('storage/asset/profile-photos/' . $user->photo) }}" style="width: 63px; height: 63px; object-fit: cover;" class="img-fluid rounded-circle" alt="SMK Baling.png">
                    @else    
                        <img src="{{ asset('asset/default-image/profile.png') }}" style="max-width: 60px;" class="img-fluid" alt="SMK Baling.png">
                    @endif
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('/notifications')
        .then(response => response.json())
        .then(data => {
            const notificationCount = document.querySelector('#notification-count');
            const dropdown = document.querySelector('#notification-dropdown');
            const totalNoti = data.notifications.length;
            
            notificationCount.innerText = totalNoti;
            
            if (totalNoti > 0) {
                dropdown.innerHTML = `
                    <li><p class="dropdown-header text-muted fw-bold">Notifications</p></li>
                    ${data.notifications.map(n => `
                        <li>
                            <a class="dropdown-item d-flex align-items-start" href="#">
                                <div class="me-3">
                                    <i class="bi bi-envelope-fill text-primary fs-5"></i>
                                </div>
                                <div>
                                    <span class="fw-bold">${n.text}</span>
                                    <small class="d-block text-muted">${new Date(n.created_at).toLocaleString()}</small>
                                </div>
                            </a>
                        </li>
                    `).join('')}
                `;
            } else {
                dropdown.innerHTML = `
                    <li><p class="dropdown-header text-muted fw-bold">Notifications</p></li>
                    <li><a class="dropdown-item text-muted">No notifications</a></li>
                `;
            }
        })
        .catch(error => {
            console.error('Error fetching notifications:', error);
            const dropdown = document.querySelector('#notification-dropdown');
            dropdown.innerHTML = `
                <li><p class="dropdown-header text-muted fw-bold">Notifications</p></li>
                <li><a class="dropdown-item text-muted">Failed to load notifications</a></li>
            `;
        });
    });
</script>