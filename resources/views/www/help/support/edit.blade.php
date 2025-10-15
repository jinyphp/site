@extends($layout ?? 'jiny-site::layouts.app')

@section('content')

@includeIf("jiny-site::www.help.partials.hero")
@includeIf("jiny-site::www.help.partials.menu")

<!-- container  -->
<section class="py-8">
    <div class="container my-lg-8">
        <div class="row">
            <div class="offset-lg-2 col-lg-8 col-12">
                <div class="mb-8">
                    <!-- heading  -->
                    <h2 class="mb-4 h1 fw-semibold">지원 요청 수정</h2>
                    <p class="lead">지원 요청 내용을 수정하실 수 있습니다. (대기중 상태에서만 가능)</p>
                </div>

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <!-- Support Edit Form -->
                <form method="POST" action="{{ url('/help/support/' . $support->id . '/edit') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">이름 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $support->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">이메일 <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $support->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">전화번호</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                   id="phone" name="phone" value="{{ old('phone', $support->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="company" class="form-label">회사/조직</label>
                            <input type="text" class="form-control @error('company') is-invalid @enderror"
                                   id="company" name="company" value="{{ old('company', $support->company) }}">
                            @error('company')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">지원 유형 <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">지원 유형을 선택하세요</option>
                                @foreach($supportTypes as $value => $label)
                                    <option value="{{ $value }}" {{ old('type', $support->type) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="priority" class="form-label">우선순위</label>
                            <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority">
                                <option value="normal" {{ old('priority', $support->priority) == 'normal' ? 'selected' : '' }}>보통</option>
                                <option value="low" {{ old('priority', $support->priority) == 'low' ? 'selected' : '' }}>낮음</option>
                                <option value="high" {{ old('priority', $support->priority) == 'high' ? 'selected' : '' }}>높음</option>
                                <option value="urgent" {{ old('priority', $support->priority) == 'urgent' ? 'selected' : '' }}>긴급</option>
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label">제목 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror"
                               id="subject" name="subject" value="{{ old('subject', $support->subject) }}" required>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">내용 <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror"
                                  id="content" name="content" rows="6" required
                                  placeholder="문제에 대해 자세히 설명해 주세요.">{{ old('content', $support->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($support->attachments && count($support->attachments) > 0)
                    <div class="mb-3">
                        <label class="form-label">현재 첨부파일</label>
                        <div class="border rounded p-3">
                            @foreach($support->attachments as $attachment)
                            <div class="d-flex align-items-center mb-2">
                                <i class="fe fe-paperclip me-2"></i>
                                <span>{{ $attachment['original_name'] ?? $attachment['filename'] }}</span>
                                <small class="text-muted ms-2">({{ number_format(($attachment['size'] ?? 0) / 1024, 1) }}KB)</small>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="mb-3">
                        <div class="alert alert-info">
                            <i class="fe fe-info me-2"></i>
                            <strong>현재 상태:</strong> {{ $support->status_label }}
                            <br>
                            <small>※ 처리 중이거나 완료된 요청은 수정할 수 없습니다.</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ url('/help/support/my') }}" class="btn btn-outline-secondary">
                            <i class="fe fe-arrow-left me-2"></i>목록으로
                        </a>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fe fe-save me-2"></i>수정 완료
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
