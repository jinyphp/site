<!-- Team Section -->
<section class="py-8 bg-white">
    <div class="container my-lg-8">
        <div class="row">
            <div class="col-lg-6 col-md-8 col-12 mb-8">
                <!-- heading -->
                <h2 class="display-4 mb-3 fw-bold">우리 팀</h2>
                <!-- lead -->
                <p class="lead mb-5">
                    전 세계 최고의 인재들과 함께 일하며 모든 기업이 사랑하는 도구를 만들고 싶으신가요?
                    Jiny Recruit 팀에 합류하여 채용의 미래를 함께 만들어가세요.
                </p>
                <!-- btn -->
                <a href="#" class="btn btn-primary">채용 공고 보기</a>
            </div>
        </div>

        <!-- Team Members Grid -->
        <div class="row">
            @php
                $teamMembers = [
                    ['name' => '김민수', 'position' => 'CEO', 'avatar' => 'avatar-1.jpg'],
                    ['name' => '이서연', 'position' => 'CTO', 'avatar' => 'avatar-2.jpg'],
                    ['name' => '박준호', 'position' => 'Head of Product', 'avatar' => 'avatar-3.jpg'],
                    ['name' => '최유진', 'position' => 'Head of Engineering', 'avatar' => 'avatar-4.jpg'],
                    ['name' => '정태현', 'position' => 'Head of Design', 'avatar' => 'avatar-5.jpg'],
                    ['name' => '한소영', 'position' => 'Head of Marketing', 'avatar' => 'avatar-6.jpg'],
                    ['name' => '조성민', 'position' => 'Senior Developer', 'avatar' => 'avatar-7.jpg'],
                    ['name' => '윤지혜', 'position' => 'UX Designer', 'avatar' => 'avatar-8.jpg'],
                    ['name' => '강동욱', 'position' => 'Data Scientist', 'avatar' => 'avatar-9.jpg'],
                    ['name' => '임채영', 'position' => 'HR Manager', 'avatar' => 'avatar-10.jpg'],
                    ['name' => '신준영', 'position' => 'Backend Developer', 'avatar' => 'avatar-11.jpg'],
                    ['name' => '오혜림', 'position' => 'Frontend Developer', 'avatar' => 'avatar-12.jpg'],
                ];
            @endphp

            @foreach ($teamMembers as $member)
                <div class="col-md-2 col-3">
                    <div class="p-xl-5 p-lg-3 mb-3 mb-lg-0">
                        <!-- avatar -->
                        <img src="{{ asset('assets/images/avatar/' . $member['avatar']) }}"
                            alt="{{ $member['name'] }}" class="imgtooltip img-fluid rounded-circle"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            title="{{ $member['name'] }} - {{ $member['position'] }}">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>