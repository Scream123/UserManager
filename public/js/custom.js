document.addEventListener('DOMContentLoaded', function () {
    let formSubmitting = false;
    document.getElementById('error-message');
    document.getElementById('success-message');
    const positionSelect = document.getElementById('position_id');

    //  user list page
    if (document.querySelector('#users-table')) {
        let currentPage = 1;
        const usersPerPage = 6;

        function loadUsers(page = 1) {
            const url = `/api/users?page=${page}&count=${usersPerPage}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const usersTable = document.querySelector('#users-table tbody');
                        data.users.forEach((user, index) => {
                            const rowNumber = (currentPage - 1) * usersPerPage + index + 1;
                            const row = `<tr>
                                            <td>${rowNumber}</td>
                                            <td>${user.name}</td>
                                            <td>${user.email}</td>
                                            <td>${user.phone}</td>
                                            <td>
                                                <a href="/users/${user.id}" class="btn btn-info">View</a>
                                            </td>
                                        </tr>`;
                            usersTable.insertAdjacentHTML('beforeend', row);
                        });

                        const loadMoreBtn = document.querySelector('#load-more-btn');
                        if (data.users.length < usersPerPage) {
                            loadMoreBtn.style.display = 'none';
                        } else {
                            loadMoreBtn.style.display = 'block';
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        const loadMoreBtn = document.querySelector('#load-more-btn');
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function (e) {
                e.preventDefault();
                currentPage++;
                loadUsers(currentPage);
            });
        }

        loadUsers(currentPage);
    }

    // single user page
    if (document.querySelector('#user-id')) {
        const userId = window.location.pathname.split('/').pop();

        if (userId) {
            function loadUserData(userId) {
                fetch(`/api/users/${userId}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.querySelector('#user-id').textContent = data.user.id;
                            document.querySelector('#user-name').textContent = data.user.name;
                            document.querySelector('#user-email').textContent = data.user.email;
                            document.querySelector('#user-phone').textContent = data.user.phone;
                            document.querySelector('#user-position').textContent = data.user.position;
                            if (data.user.photo) {
                                document.getElementById('user-photo').src = data.user.photo;
                            } else {
                                document.getElementById('user-photo').style.display = 'none';
                            }

                            document.querySelector('.card-body').style.display = 'block';
                        } else {
                            document.querySelector('#user-error').style.display = 'block';
                        }
                    })
                    .catch(error => {
                        console.error('Error loading user data:', error);
                        document.querySelector('#user-error').style.display = 'block';
                    });
            }

            loadUserData(userId);
        }
    }

    //creating a user with a token in the title
    function createUser(submitButton) {
        const token = localStorage.getItem('authToken');
        if (!token) {
            resetFormState(submitButton);
            return;
        }

        const form = document.getElementById('create-user-form');
        const formData = new FormData(form);

        fetch('/api/users', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('success-message').textContent = 'User created successfully!';
                    document.getElementById('success-message').classList.remove('d-none');
                    form.reset(); // Очистка формы
                } else {
                    document.getElementById('error-message').textContent = data.message || 'Failed to create user.';
                    document.getElementById('error-message').style.display = 'block';
                }
                resetFormState(submitButton);
            })
            .catch(error => {
                console.error('Error creating user:', error);
                document.getElementById('error-message').textContent = 'Error creating user: ' + error.message;
                document.getElementById('error-message').style.display = 'block';
                resetFormState(submitButton);
            });
    }

    // Unlock the button and reset the flag
    const generateTokenBtn = document.getElementById('generate-token-btn');
    const tokenMessage = document.getElementById('token-message');

    if (generateTokenBtn) {
        generateTokenBtn.addEventListener('click', function () {
            fetch('/token')
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.token) {
                        localStorage.setItem('authToken', data.token);
                        tokenMessage.textContent = 'Token generated: ';
                        tokenMessage.classList.remove('d-none');
                    } else {
                        tokenMessage.textContent = 'ERROR: ' + data.message;
                        tokenMessage.classList.remove('d-none');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    tokenMessage.textContent = 'Error generating token';
                    tokenMessage.classList.remove('d-none');
                });
        });
    }

    // Form Submission Handler
    const form = document.getElementById('create-user-form');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            //if the form is already being submitted, then do not continue
            if (formSubmitting) return;

            // Set a flag that the form is being submitted
            formSubmitting = true;

            // Blocking the submit button
            const submitButton = document.querySelector('form button[type="submit"]');
            submitButton.disabled = true;

            const formData = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                position_id: document.getElementById('position_id').value,
                photo: document.getElementById('photo').value,
            };

            createUser(formData, submitButton);
        });
    }

    function loadPositions() {
        const token = localStorage.getItem('authToken');

        if (!token) {
            console.error('No auth token found!');
            return;
        }

        fetch('/api/positions', {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.positions.length > 0) {
                    positionSelect.innerHTML = '';

                    const defaultOption = document.createElement('option');
                    defaultOption.value = '';
                    defaultOption.textContent = 'Select Position';
                    positionSelect.appendChild(defaultOption);

                    data.positions.forEach(position => {
                        const option = document.createElement('option');
                        option.value = position.id;
                        option.textContent = position.name;
                        positionSelect.appendChild(option);
                    });
                } else {
                    console.error('No positions found.');
                }
            })
            .catch(error => {
                console.error('Error loading positions:', error);
            });
    }

    loadPositions();

    //Unlock the button and reset the flag
    function resetFormState(submitButton) {
        formSubmitting = false;
        submitButton.disabled = false;
    }
});
