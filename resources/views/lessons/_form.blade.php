@php
    $lesson = $lesson ?? null;
    $isCreating = $course === null;
@endphp

<div class="form-group">
    <label for="title" class="form-label">Заголовок *</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $lesson?->title) }}" maxlength="50" required>
    <div class="form-text">Максимум 50 символов</div>
    @error('title')
    <div class="error-message">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="content" class="form-label">Текстовое содержание *</label>
    <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10" required>{{ old('content', $lesson?->content) }}</textarea>
    @error('content')
    <div class="error-message">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="video_link" class="form-label">Видеоссылка SuperTube</label>
    <input type="url" class="form-control @error('video_link') is-invalid @enderror" id="video_link" name="video_link" value="{{ old('video_link', $lesson?->video_link) }}"
           placeholder="https://super-tube.cc/video/v23189">
    @error('video_link')
    <div class="error-message">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="duration" class="form-label">Длительность (часы) *</label>
    <input type="number" class="form-control @error('duration_hours') is-invalid @enderror" id="duration_hours" name="duration_hours" value="{{ old('duration_hours', $lesson?->duration_hours) }}" min="1" max="4"
           required>
    <div class="form-text">Максимум 4 часа</div>
    @error('duration_hours')
    <div class="error-message">{{ $message }}</div>
    @enderror
</div>
