@php
    $course = $course ?? null;
    $isCreating = $course === null;
@endphp

<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label for="name" class="form-label">Название курса *</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                   value="{{ old('name', $course?->name) }}">
            <div class="form-text">Обязательное поле, максимум 30 символов</div>
            @error('name')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Описание курса</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                      name="description"
                      rows="3"
                      maxlength="100">{{ old('description', $course?->description) }}</textarea>
            <div class="form-text">Необязательное поле, максимум 100 символов</div>
            @error('description')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="duration" class="form-label">Продолжительность (в часах) *</label>
                    <input type="text" class="form-control @error('duration_hours') is-invalid @enderror"
                           id="duration_hours"
                           name="duration_hours"
                           value="{{ old('duration_hours', $course?->duration_hours) }}">
                    <div class="form-text">Обязательное поле, целое число не больше 10 часов</div>
                    @error('duration_hours')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="price" class="form-label">Цена *</label>
                    <input type="text" class="form-control @error('price') is-invalid @enderror" id="price"
                           name="price"
                           value="{{ old('price', $course?->price) }}">
                    <div class="form-text">Обязательное поле, формат «хх.хх», не менее 100</div>
                    @error('price')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="start_date" class="form-label">Дата начала *</label>
                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date"
                           name="start_date"
                           value="{{ old('start_date', $course?->start_date?->format('Y-m-d')) }}" >
                    <div class="form-text">Обязательное поле</div>
                    @error('start_date')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="end_date" class="form-label">Дата окончания *</label>
                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date"
                           name="end_date"
                           value="{{ old('end_date', $course?->end_date?->format('Y-m-d')) }}" >
                    <div class="form-text">Обязательное поле</div>
                    @error('end_date')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="cover" class="form-label">Обложка курса (изображение) *</label>

            <input type="file" class="form-control @error('cover_image_path') is-invalid @enderror"
                   id="cover_image_path" name="cover_image_path"
                   accept="image/jpeg" {{ $isCreating ? '' : '' }}>
            <div class="form-text">
                @if($isCreating)
                    Обязательное поле при создании<br>
                @else
                    Оставьте пустым, чтобы не изменять обложку<br>
                @endif
                JPG (JPEG), максимум 2000 Кб<br>
                Будет автоматически конвертирована в миниатюру 300×300px<br>
            </div>
            @error('cover_image_path')
            @foreach ($errors->get('cover_image_path') as $error_message)
                <div class="error-message">{{ $error_message }}</div>
            @endforeach
            @enderror
        </div>

        <div class="card mt-4 info-card">
            <div class="card-body">
                <h6>
                    <img src="{{ asset('assets/img/info.svg') }}" alt="Информация" class="icon">
                    Информация о курсе
                </h6>
                <ul class="small mb-0" style="padding-left: 20px;">
                    <li>Максимально 5 уроков на курс</li>
                    <li>После создания можно добавить уроки</li>
                    <li>Обложка будет автоматически обработана</li>
                </ul>
            </div>
        </div>
    </div>
</div>


