<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <div class="flex flex-col md:flex-row gap-8">
        <!-- Left side: your original form -->
        <div class="flex-1">
            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                @csrf
                @method('patch')

                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div>
                            <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                {{ __('Your email address is unverified.') }}
                                <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>
                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Cropper-Enabled Image Upload -->
                <div>
                    <x-input-label for="file" :value="__('Profile Upload')" />
                    <input type="file" id="file" name="file" accept="image/*" onchange="handleFileChange(event)" class="mt-1 block w-full" />
                    <x-input-error class="mt-2" :messages="$errors->get('file')" />
                    <canvas id="canvas-preview" class="hidden mx-auto mt-4 border" style="max-width: 100%;"></canvas>

                    
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>

                    @if (session('status') === 'profile-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600 dark:text-gray-400"
                        >{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>
        </div>

        <!-- Right side: profile photo upload preview -->
        <div class="w-full md:w-1/3 mt-6 md:mt-0 text-center">
            <div class="mt-4">
                <img id="photo-preview"
                    src="{{ $user->file ? asset('storage/' . $user->file) : 'https://via.placeholder.com/150' }}"
                    alt="Profile Photo"
                    class="h-32 w-32 object-cover mx-auto border" />
            </div>
        </div>
    </div>
</section>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
     let cropper;
    let cropTimeout;

    function handleFileChange(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            const image = new Image();
            image.src = e.target.result;
            image.onload = function () {
                const canvas = document.getElementById('canvas-preview');
                const ctx = canvas.getContext('2d');
                canvas.width = image.width;
                canvas.height = image.height;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(image, 0, 0);
                canvas.classList.remove('hidden');

                if (cropper) cropper.destroy();

                cropper = new Cropper(canvas, {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 1,
                    scalable: true,
                    zoomable: true,
                    ready() {
                        // Listen for any crop events and debounce the crop
                        canvas.addEventListener('crop', debounceCrop);
                    },
                    crop() {
                        // Debounce: call cropImage() after short pause
                        clearTimeout(cropTimeout);
                        cropTimeout = setTimeout(cropImage, 500);
                    }
                });
            };
        };
        reader.readAsDataURL(file);
    }

    function cropImage() {
        if (!cropper) return;

        const canvas = cropper.getCroppedCanvas({
            width: 300,
            height: 300,
        });

        // Update preview
        document.getElementById('photo-preview').src = canvas.toDataURL();

        // Convert canvas to blob and update file input
        canvas.toBlob(function (blob) {
            const fileInput = document.getElementById('file');
            const newFile = new File([blob], "profile.png", { type: "image/png" });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(newFile);
            fileInput.files = dataTransfer.files;
        });
    }

    function debounceCrop() {
        clearTimeout(cropTimeout);
        cropTimeout = setTimeout(cropImage, 500);
    }
</script>
@endpush
