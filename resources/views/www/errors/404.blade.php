<x-www-app>
    <main class="d-flex w-100 h-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center">
							<h1 class="display-1 fw-bold">404</h1>
							<p class="h2">페이지를 찾을 수 없습니다.</p>

                            {{--
                            <p class="lead fw-normal mt-3 mb-4">
                                The page you are looking for might have been removed.
                            </p>
							 --}}

                            {{-- 404에서 신규 페이지를 생성합니다. --}}
                            @livewire('site-new-page')
                            <script>
                                document.addEventListener('livewire:init', () => {
                                    Livewire.on('page-realod', (event) => {
                                        console.log("page-realod");
                                        location.reload();
                                    });
                                });
                            </script>

						</div>

					</div>
				</div>
			</div>
		</div>
	</main>

</x-www-app>
