
    <div>
        <div id="frame">
            <video id="videoElement" width="640" height="480" autoplay></video>
            <button id="recordButton">Record</button>
            <button id="stopButton">Stop</button>
            <button id="saveButton" style="display: none;">Saving...</button>
        </div>
        @script
            <script>
                const videoElement = document.getElementById('videoElement');
                const recordButton = document.getElementById('recordButton');
                const stopButton = document.getElementById('stopButton');
                const saveButton = document.getElementById('saveButton');

                let mediaRecorder;
                let recordedChunks = [];

                navigator.mediaDevices.getUserMedia({ video: true })
                    .then(stream => {
                        videoElement.srcObject = stream;
                        mediaRecorder = new MediaRecorder(stream);

                        recordButton.addEventListener('click', () => {
                            mediaRecorder.start();
                            recordButton.style.display = 'none';
                            stopButton.style.display = 'inline-block';
                        });

                        stopButton.addEventListener('click', () => {
                            mediaRecorder.stop();
                            stopButton.style.display = 'none';
                            saveButton.style.display = 'inline-block';
                        });

                        mediaRecorder.ondataavailable = event => {
                            recordedChunks.push(event.data);
                        };

                        mediaRecorder.onstop = () => {
                            const blob = new Blob(recordedChunks, { type: 'video/webm' });
                            const formData = new FormData();
                            formData.append('video', blob);

                            fetch('/save-video', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                },
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    saveButton.style.display = 'none';
                                    recordButton.style.display = 'inline-block';
                                    if(!alert('Video saved successfully!')){window.location.reload();}
                                } else {
                                    console.error('Failed to save video');
                                }
                            });
                        };
                    })
                    .catch(error => {
                        console.error('Error accessing webcam:', error);
                    });
            </script>
        @endscript
    </div>