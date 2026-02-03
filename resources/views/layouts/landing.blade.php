<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vreator - Platform Marketplace Content Creator & Video Editor</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="icon" href="{{ asset ('landing/img/LandingVreator.png')}}">
    <link rel="stylesheet" href="landing/css/landing.css">

</head>
<body>

    @include('layouts.components-landing.navbar')

    @yield('content')

    @include('layouts.components-landing.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        let selectedUserRole = '';
        
        function selectRole(role) {
            selectedUserRole = role;
            
            // Hide step 1, show step 2
            document.getElementById('step1').classList.remove('active');
            document.getElementById('step2').classList.add('active');
            
            // Update icon and text based on role
            const iconElement = document.querySelector('#selectedRoleIcon i');
            const textElement = document.getElementById('selectedRoleText');
            
            if (role === 'creator') {
                iconElement.className = 'bi bi-camera-video-fill';
                textElement.textContent = 'Masuk sebagai Editor / Creator';
            } else {
                iconElement.className = 'bi bi-bag-fill';
                textElement.textContent = 'Masuk sebagai Buyer';
            }
        }
        
        function backToStep1() {
            document.getElementById('step2').classList.remove('active');
            document.getElementById('step1').classList.add('active');
            selectedUserRole = '';
        }
        
        // Reset modal when closed
        document.getElementById('loginModal').addEventListener('hidden.bs.modal', function () {
            backToStep1();
        });

        function goToRegister(role) {
            window.location.href = `/register?role=${role}`;
        }

    </script>
</body>
</html>