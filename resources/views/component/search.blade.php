<div class="c-search {{ $modifiers or '' }}">

    <div class="c-search__form">

        <span class="c-search__form-icon">

            @include('component.icon', [
                'icon' => 'icon-search'
            ])

        </span>

        <input type="text" class="c-search__form-input" placeholder="{{ $placeholder }}">
    </div>

    <div class="c-search__results">

        <div class="c-search__results-content">

            <ul class="c-search__results-list m-destinations">

                <li class="c-search__results-list-item">
                    Sihtkohad
                    <ul class="c-search__results-sublist">
                        <li class="c-search__results-sublist-item"><a href="#" class="c-search__results-link">Barcelona, Hispaania</a></li>
                        <li class="c-search__results-sublist-item"><a href="#" class="c-search__results-link">Barcelonette, Prantsusmaa</a></li>
                    </ul>
                </li>

            </ul>

            <ul class="c-search__results-list m-offers">

                <li class="c-search__results-list-item">
                    Lennupakkumised
                    <ul class="c-search__results-sublist">
                        <li class="c-search__results-sublist-item"><a href="#" class="c-search__results-link">Ryanair otselendudega märtsis-aprillis Tallinn–Barcelona–Tallinn al 68 €</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="c-search__results-list m-forum">

                <li class="c-search__results-list-item">
                    Foorum
                    <ul class="c-search__results-sublist">
                        <li class="c-search__results-sublist-item">
                            <a href="#" class="c-search__results-link">
                                <div class="c-search__results-link-profile">
                                    <div class="c-profile m-micro">
                                        <div class="c-profile__image-wrap">
                                            <img src="images/dummy/profile1.jpg" alt="" class="c-profile__image">
                                        </div>
                                    </div>
                                </div>
                                <div class="c-search__results-link-text">
                                    Olge Barcelonas tähelepanelikud
                                </div>
                            </a>
                        </li>
                        <li class="c-search__results-sublist-item">
                            <a href="#" class="c-search__results-link">
                                <div class="c-search__results-link-profile">
                                    <div class="c-profile m-micro">
                                        <div class="c-profile__image-wrap">
                                            <img src="images/dummy/profile2.jpg" alt="" class="c-profile__image">
                                        </div>
                                    </div>
                                </div>
                                <div class="c-search__results-link-text">
                                    Girona-Barcelona, autorent, hinnad ja majutus
                                </div>
                            </a>
                        </li>
                        <li class="c-search__results-sublist-item">
                            <a href="#" class="c-search__results-link">
                                <div class="c-search__results-link-profile">
                                    <div class="c-profile m-micro">
                                        <div class="c-profile__image-wrap">
                                            <img src="images/dummy/profile1.jpg" alt="" class="c-profile__image">
                                        </div>
                                    </div>
                                </div>
                                <div class="c-search__results-link-text">
                                    Olge Barcelonas tähelepanelikud
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>

        </div>

        <footer class="c-search__results-footer">
            <a href="#" class="c-link">Kõik tulemused (123)</a>
        </footer>
    </div>
</div>