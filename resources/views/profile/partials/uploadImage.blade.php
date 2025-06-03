<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Cropper CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

    <style>
        /* تنسيقات عامة */
        .image-editor-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
        }

        .file-input {
            position: absolute;
            opacity: 0;
            width: 1px;
            height: 1px;
        }

        /* معاينة الصورة */
        .image-preview-container {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid #e0e0e0;
            cursor: pointer;
            position: relative;
            background-color: #f8f9fa;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .image-preview-container:hover {
            border-color: #2196F3;
            transform: scale(1.02);
        }

        .image-preview-container:hover .preview-image {
            transform: scale(1.1);
            filter: brightness(0.9);
        }

        .image-preview-container::after {
            content: 'تغيير الصورة';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 500;
            opacity: 0;
            transition: opacity 0.3s, transform 0.3s;
            pointer-events: none;
            white-space: nowrap;
        }

        .image-preview-container:hover::after {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1.05);
        }

        /* نافذة التحرير */
        .cropper-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(12px) brightness(0.8);
            -webkit-backdrop-filter: blur(12px) brightness(0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            animation: fadeIn 0.3s ease-out;
        }

        .cropper-dialog {
            background-color: white;
            border-radius: 12px;
            width: 90%;
            max-width: 650px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transform: scale(0.95);
            opacity: 0;
            animation: modalIn 0.3s ease-out 0.1s forwards;
        }

        .cropper-header {
            padding: 18px;
            font-size: 1.3rem;
            font-weight: 600;
            text-align: center;
            border-bottom: 1px solid #eee;
            background-color: #f9f9f9;
            color: #333;
        }

        .cropper-body {
            padding: 25px;
            max-height: 70vh;
            overflow: auto;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .cropper-image {
            max-width: 100%;
            max-height: 60vh;
            display: block;
            margin: 0 auto;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }

        .cropper-footer {
            display: flex;
            justify-content: flex-end;
            padding: 18px;
            gap: 12px;
            border-top: 1px solid #eee;
            background-color: #f9f9f9;
        }

        /* الأزرار */
        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s ease;
            font-size: 15px;
            min-width: 100px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .cancel-btn {
            background-color: #f44336;
            color: white;
            border: 1px solid #d32f2f;
        }

        .cancel-btn:hover {
            background-color: #d32f2f;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
        }

        .save-btn {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #388E3C;
        }

        .save-btn:hover {
            background-color: #388E3C;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
        }

        .cropper-modal {
            background-color: none !important;
            opacity: 1 !important;
        }

        .save-button {
            padding: 12px 24px;
            background-color: #2196F3;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s;
            box-shadow: 0 3px 8px rgba(33, 150, 243, 0.3);
            margin-top: 10px;
        }

        .save-button:hover {
            background-color: #0b7dda;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(33, 150, 243, 0.4);
        }

        .save-button:disabled {
            background-color: #b0b0b0;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* تأثيرات الحركة */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes modalIn {
            from {
                transform: scale(0.95);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .preview-image.loaded {
            animation: fadeIn 0.5s ease;
        }

        /* تأثيرات التركيز */
        .cropper-dialog:focus-within {
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.5);
        }

        .btn:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.5);
        }

        /* تنسيقات للجوال */
        @media (max-width: 768px) {
            .cropper-dialog {
                width: 95%;
                max-width: 95%;
            }

            .image-preview-container {
                width: 150px;
                height: 150px;
            }

            .cropper-body {
                padding: 15px;
                max-height: 60vh;
            }

            .btn {
                padding: 8px 16px;
                min-width: 80px;
            }
        }

        @media (max-width: 480px) {
            .image-preview-container {
                width: 130px;
                height: 130px;
            }

            .cropper-header {
                padding: 15px;
                font-size: 1.1rem;
            }

            .cropper-footer {
                padding: 15px;
                justify-content: center;
            }
        }
    </style>

    <!-- Cropper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>

<body>
    <div class="image-editor-container">
        <input type="file" id="imageInput" accept="image/*" class="file-input">
        <div class="image-preview-container">
            <img id="previewImage" src="{{ Auth::user()->image ? asset('staff_img/' . Auth::user()->image) : 'staff_img/1.png' }}"
                class="preview-image" alt="صورة المستخدم">

        </div>

        <div id="cropperModal" class="cropper-modal">
            <div class="cropper-dialog">
                <div class="cropper-header">قص الصورة</div>
                <div class="cropper-body">
                    <img id="cropImage" src="" class="cropper-image" />
                </div>
                <div class="cropper-footer">
                    <button id="cancelCrop" class="btn cancel-btn">إلغاء</button>
                    <button id="cropAndPreview" class="btn save-btn">إضافة</button>
                </div>
            </div>
        </div>

        <button id="saveImageBtn" class="save-button" disabled>Save Image</button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('imageInput');
            const previewImage = document.getElementById('previewImage');
            const cropperModal = document.getElementById('cropperModal');
            const cropImage = document.getElementById('cropImage');
            const cropAndPreview = document.getElementById('cropAndPreview');
            const cancelCrop = document.getElementById('cancelCrop');
            const saveBtn = document.getElementById('saveImageBtn');
            const imageContainer = document.querySelector('.image-preview-container');

            let cropper;
            let croppedBlob = null;

            imageContainer.addEventListener('click', () => imageInput.click());

            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file && file.type.match('image.*')) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        cropImage.src = event.target.result;
                        cropperModal.style.display = 'flex';

                        cropImage.onload = function() {
                            if (cropper) cropper.destroy();
                            cropper = new Cropper(cropImage, {
                                aspectRatio: 1,
                                viewMode: 1,
                                autoCropArea: 0.8,
                                responsive: true,
                                restore: false,
                                guides: false,
                                center: true,
                                highlight: false,
                                cropBoxMovable: true,
                                cropBoxResizable: true,
                                toggleDragModeOnDblclick: false,
                            });
                        };
                    };
                    reader.readAsDataURL(file);
                }
            });

            cropAndPreview.addEventListener('click', function() {
                if (cropper) {
                    cropper.getCroppedCanvas({
                        width: 500,
                        height: 500,
                        fillColor: '#fff',
                        imageSmoothingEnabled: true,
                        imageSmoothingQuality: 'high',
                    }).toBlob(function(blob) {
                        croppedBlob = blob;
                        previewImage.src = URL.createObjectURL(blob);
                        previewImage.classList.add('loaded');
                        cropperModal.style.display = 'none';
                        saveBtn.disabled = false;
                    }, 'image/jpeg', 0.9);
                }
            });

            cancelCrop.addEventListener('click', function() {
                cropperModal.style.display = 'none';
                if (cropper) cropper.destroy();
            });

            saveBtn.addEventListener('click', function() {
                if (!croppedBlob) return;

                saveBtn.disabled = true;
                saveBtn.textContent = 'جاري الحفظ...';

                const formData = new FormData();
                formData.append('image', croppedBlob, 'profile.jpg');

                fetch('{{ route("profile.uploadImage") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            toastr.success('تم حفظ الصورة بنجاح');
                            previewImage.src = '/storage/' + data.path + '?t=' + new Date().getTime();
                        } else {
                            toastr.error(data.message || 'حدث خطأ أثناء حفظ الصورة');
                        }
                    })
                    .catch(() => {
                        toastr.error('فشل الاتصال بالسيرفر');
                    })
                    .finally(() => {
                        saveBtn.disabled = false;
                        saveBtn.textContent = 'حفظ الصورة';
                    });
            });
        });
    </script>


</body>

</html>