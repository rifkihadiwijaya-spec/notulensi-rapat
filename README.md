
```
notulensi-rapat
├─ .editorconfig
├─ app
│  ├─ Http
│  │  ├─ Controllers
│  │  │  ├─ Auth
│  │  │  │  ├─ AuthenticatedSessionController.php
│  │  │  │  ├─ ConfirmablePasswordController.php
│  │  │  │  ├─ EmailVerificationNotificationController.php
│  │  │  │  ├─ EmailVerificationPromptController.php
│  │  │  │  ├─ NewPasswordController.php
│  │  │  │  ├─ PasswordController.php
│  │  │  │  ├─ PasswordResetLinkController.php
│  │  │  │  ├─ RegisteredUserController.php
│  │  │  │  └─ VerifyEmailController.php
│  │  │  ├─ Controller.php
│  │  │  ├─ DashboardController.php
│  │  │  ├─ MeetingController.php
│  │  │  ├─ MeetingQuestionController.php
│  │  │  └─ UserController.php
│  │  ├─ Middleware
│  │  │  └─ IsAdmin.php
│  │  └─ Requests
│  │     ├─ Auth
│  │     │  └─ LoginRequest.php
│  │     └─ ProfileUpdateRequest.php
│  ├─ Models
│  │  ├─ Meeting.php
│  │  ├─ MeetingDokumentasi.php
│  │  ├─ MeetingQuestion.php
│  │  └─ User.php
│  ├─ Policies
│  │  └─ MeetingPolicy.php
│  ├─ Providers
│  │  └─ AppServiceProvider.php
│  └─ View
│     └─ Components
│        ├─ AppLayout.php
│        └─ GuestLayout.php
├─ artisan
├─ bootstrap
│  ├─ app.php
│  ├─ cache
│  │  ├─ packages.php
│  │  └─ services.php
│  └─ providers.php
├─ composer.json
├─ composer.lock
├─ config
│  ├─ app.php
│  ├─ auth.php
│  ├─ cache.php
│  ├─ database.php
│  ├─ filesystems.php
│  ├─ logging.php
│  ├─ mail.php
│  ├─ queue.php
│  ├─ services.php
│  └─ session.php
├─ database
│  ├─ database.sqlite
│  ├─ factories
│  │  └─ UserFactory.php
│  ├─ migrations
│  │  ├─ 0001_01_01_000000_create_users_table.php
│  │  ├─ 0001_01_01_000001_create_cache_table.php
│  │  ├─ 0001_01_01_000002_create_jobs_table.php
│  │  ├─ 2026_02_10_070841_add_role_to_users_table.php
│  │  ├─ 2026_02_10_072331_create_meetings_table.php
│  │  ├─ 2026_02_10_072826_create_meeting_questions_table.php
│  │  ├─ 2026_03_05_033916_add_username_to_users_table.php
│  │  ├─ 2026_03_05_044849_make_email_nullable_in_users_table.php
│  │  ├─ 2026_03_09_053348_fix_meetings_foreign_keys_null_on_delete.php
│  │  ├─ 2026_03_10_025756_add_name_snapshot_to_meetings_table.php
│  │  ├─ 2026_03_10_025757_add_name_snapshot_to_meeting_questions_table.php
│  │  └─ 2026_04_06_003443_create_meeting_dokumentasi_table.php
│  └─ seeders
│     └─ DatabaseSeeder.php
├─ package-lock.json
├─ package.json
├─ phpunit.xml
├─ postcss.config.js
├─ public
│  ├─ .htaccess
│  ├─ css
│  ├─ favicon.ico
│  ├─ images
│  │  └─ logo-diskominfo.png
│  ├─ index.php
│  ├─ js
│  │  └─ tinymce
│  │     ├─ CHANGELOG.md
│  │     ├─ icons
│  │     │  └─ default
│  │     │     └─ icons.min.js
│  │     ├─ langs
│  │     │  └─ README.md
│  │     ├─ license.md
│  │     ├─ models
│  │     │  └─ dom
│  │     │     └─ model.min.js
│  │     ├─ notices.txt
│  │     ├─ plugins
│  │     │  ├─ accordion
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ advlist
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ anchor
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ autolink
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ autoresize
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ autosave
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ charmap
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ code
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ codesample
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ directionality
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ emoticons
│  │     │  │  ├─ js
│  │     │  │  │  ├─ emojiimages.js
│  │     │  │  │  ├─ emojiimages.min.js
│  │     │  │  │  ├─ emojis.js
│  │     │  │  │  └─ emojis.min.js
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ fullscreen
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ help
│  │     │  │  ├─ js
│  │     │  │  │  └─ i18n
│  │     │  │  │     └─ keynav
│  │     │  │  │        ├─ ar.js
│  │     │  │  │        ├─ bg-BG.js
│  │     │  │  │        ├─ bg_BG.js
│  │     │  │  │        ├─ ca.js
│  │     │  │  │        ├─ cs.js
│  │     │  │  │        ├─ da.js
│  │     │  │  │        ├─ de.js
│  │     │  │  │        ├─ el.js
│  │     │  │  │        ├─ en.js
│  │     │  │  │        ├─ es.js
│  │     │  │  │        ├─ eu.js
│  │     │  │  │        ├─ fa.js
│  │     │  │  │        ├─ fi.js
│  │     │  │  │        ├─ fr-FR.js
│  │     │  │  │        ├─ fr_FR.js
│  │     │  │  │        ├─ he-IL.js
│  │     │  │  │        ├─ he_IL.js
│  │     │  │  │        ├─ hi.js
│  │     │  │  │        ├─ hr.js
│  │     │  │  │        ├─ hu-HU.js
│  │     │  │  │        ├─ hu_HU.js
│  │     │  │  │        ├─ id.js
│  │     │  │  │        ├─ it.js
│  │     │  │  │        ├─ ja.js
│  │     │  │  │        ├─ kk.js
│  │     │  │  │        ├─ ko-KR.js
│  │     │  │  │        ├─ ko_KR.js
│  │     │  │  │        ├─ ms.js
│  │     │  │  │        ├─ nb-NO.js
│  │     │  │  │        ├─ nb_NO.js
│  │     │  │  │        ├─ nl.js
│  │     │  │  │        ├─ pl.js
│  │     │  │  │        ├─ pt-BR.js
│  │     │  │  │        ├─ pt-PT.js
│  │     │  │  │        ├─ pt_BR.js
│  │     │  │  │        ├─ pt_PT.js
│  │     │  │  │        ├─ ro.js
│  │     │  │  │        ├─ ru.js
│  │     │  │  │        ├─ sk.js
│  │     │  │  │        ├─ sl-SI.js
│  │     │  │  │        ├─ sl_SI.js
│  │     │  │  │        ├─ sv-SE.js
│  │     │  │  │        ├─ sv_SE.js
│  │     │  │  │        ├─ th-TH.js
│  │     │  │  │        ├─ th_TH.js
│  │     │  │  │        ├─ tr.js
│  │     │  │  │        ├─ uk.js
│  │     │  │  │        ├─ vi.js
│  │     │  │  │        ├─ zh-CN.js
│  │     │  │  │        ├─ zh-TW.js
│  │     │  │  │        ├─ zh_CN.js
│  │     │  │  │        └─ zh_TW.js
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ image
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ importcss
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ insertdatetime
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ link
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ lists
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ media
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ nonbreaking
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ pagebreak
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ preview
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ quickbars
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ save
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ searchreplace
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ table
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ visualblocks
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ visualchars
│  │     │  │  └─ plugin.min.js
│  │     │  └─ wordcount
│  │     │     └─ plugin.min.js
│  │     ├─ skins
│  │     │  ├─ content
│  │     │  │  ├─ dark
│  │     │  │  │  ├─ content.js
│  │     │  │  │  └─ content.min.css
│  │     │  │  ├─ default
│  │     │  │  │  ├─ content.js
│  │     │  │  │  └─ content.min.css
│  │     │  │  ├─ document
│  │     │  │  │  ├─ content.js
│  │     │  │  │  └─ content.min.css
│  │     │  │  ├─ tinymce-5
│  │     │  │  │  ├─ content.js
│  │     │  │  │  └─ content.min.css
│  │     │  │  ├─ tinymce-5-dark
│  │     │  │  │  ├─ content.js
│  │     │  │  │  └─ content.min.css
│  │     │  │  └─ writer
│  │     │  │     ├─ content.js
│  │     │  │     └─ content.min.css
│  │     │  └─ ui
│  │     │     ├─ oxide
│  │     │     │  ├─ content.inline.js
│  │     │     │  ├─ content.inline.min.css
│  │     │     │  ├─ content.js
│  │     │     │  ├─ content.min.css
│  │     │     │  ├─ skin.js
│  │     │     │  ├─ skin.min.css
│  │     │     │  ├─ skin.shadowdom.js
│  │     │     │  └─ skin.shadowdom.min.css
│  │     │     ├─ oxide-dark
│  │     │     │  ├─ content.inline.js
│  │     │     │  ├─ content.inline.min.css
│  │     │     │  ├─ content.js
│  │     │     │  ├─ content.min.css
│  │     │     │  ├─ skin.js
│  │     │     │  ├─ skin.min.css
│  │     │     │  ├─ skin.shadowdom.js
│  │     │     │  └─ skin.shadowdom.min.css
│  │     │     ├─ tinymce-5
│  │     │     │  ├─ content.inline.js
│  │     │     │  ├─ content.inline.min.css
│  │     │     │  ├─ content.js
│  │     │     │  ├─ content.min.css
│  │     │     │  ├─ skin.js
│  │     │     │  ├─ skin.min.css
│  │     │     │  ├─ skin.shadowdom.js
│  │     │     │  └─ skin.shadowdom.min.css
│  │     │     └─ tinymce-5-dark
│  │     │        ├─ content.inline.js
│  │     │        ├─ content.inline.min.css
│  │     │        ├─ content.js
│  │     │        ├─ content.min.css
│  │     │        ├─ skin.js
│  │     │        ├─ skin.min.css
│  │     │        ├─ skin.shadowdom.js
│  │     │        └─ skin.shadowdom.min.css
│  │     ├─ themes
│  │     │  └─ silver
│  │     │     └─ theme.min.js
│  │     ├─ tinymce.d.ts
│  │     └─ tinymce.min.js
│  └─ robots.txt
├─ README.md
├─ resources
│  ├─ css
│  │  ├─ app.css
│  │  ├─ auth.css
│  │  ├─ main.css
│  │  └─ responsive.css
│  ├─ js
│  │  ├─ app.js
│  │  ├─ bootstrap.js
│  │  ├─ modules
│  │  │  ├─ animations.js
│  │  │  ├─ flash.js
│  │  │  ├─ modal.js
│  │  │  ├─ qa.js
│  │  │  ├─ server-search.js
│  │  │  └─ table-filter.js
│  │  └─ pages
│  │     ├─ dashboard.js
│  │     ├─ edit.js
│  │     ├─ meetings.js
│  │     ├─ show.js
│  │     └─ users.js
│  └─ views
│     ├─ auth
│     │  ├─ confirm-password.blade.php
│     │  ├─ forgot-password.blade.php
│     │  ├─ login.blade.php
│     │  ├─ register.blade.php
│     │  ├─ reset-password.blade.php
│     │  └─ verify-email.blade.php
│     ├─ components
│     │  ├─ application-logo.blade.php
│     │  ├─ auth-session-status.blade.php
│     │  ├─ danger-button.blade.php
│     │  ├─ dropdown-link.blade.php
│     │  ├─ dropdown.blade.php
│     │  ├─ input-error.blade.php
│     │  ├─ input-label.blade.php
│     │  ├─ modal.blade.php
│     │  ├─ nav-link.blade.php
│     │  ├─ primary-button.blade.php
│     │  ├─ responsive-nav-link.blade.php
│     │  ├─ secondary-button.blade.php
│     │  └─ text-input.blade.php
│     ├─ dashboard.blade.php
│     ├─ layouts
│     │  ├─ app.blade.php
│     │  ├─ guest.blade.php
│     │  └─ navigation.blade.php
│     ├─ meetings
│     │  ├─ create.blade.php
│     │  ├─ edit.blade.php
│     │  ├─ index.blade.php
│     │  ├─ pdf.blade.php
│     │  └─ show.blade.php
│     └─ users
│        ├─ create.blade.php
│        ├─ edit.blade.php
│        └─ index.blade.php
├─ route('login')
├─ routes
│  ├─ auth.php
│  ├─ console.php
│  └─ web.php
├─ tailwind.config.js
├─ tests
│  ├─ Feature
│  │  ├─ Auth
│  │  │  ├─ AuthenticationTest.php
│  │  │  ├─ EmailVerificationTest.php
│  │  │  ├─ PasswordConfirmationTest.php
│  │  │  ├─ PasswordResetTest.php
│  │  │  ├─ PasswordUpdateTest.php
│  │  │  └─ RegistrationTest.php
│  │  └─ ExampleTest.php
│  ├─ TestCase.php
│  └─ Unit
│     └─ ExampleTest.php
└─ vite.config.js

```
```
sinora-notulensi
├─ .editorconfig
├─ app
│  ├─ Http
│  │  ├─ Controllers
│  │  │  ├─ Auth
│  │  │  │  ├─ AuthenticatedSessionController.php
│  │  │  │  ├─ ConfirmablePasswordController.php
│  │  │  │  ├─ EmailVerificationNotificationController.php
│  │  │  │  ├─ EmailVerificationPromptController.php
│  │  │  │  ├─ NewPasswordController.php
│  │  │  │  ├─ PasswordController.php
│  │  │  │  ├─ PasswordResetLinkController.php
│  │  │  │  ├─ RegisteredUserController.php
│  │  │  │  └─ VerifyEmailController.php
│  │  │  ├─ Controller.php
│  │  │  ├─ DashboardController.php
│  │  │  ├─ MeetingController.php
│  │  │  ├─ MeetingQuestionController.php
│  │  │  └─ UserController.php
│  │  ├─ Middleware
│  │  │  └─ IsAdmin.php
│  │  └─ Requests
│  │     ├─ Auth
│  │     │  └─ LoginRequest.php
│  │     ├─ ProfileUpdateRequest.php
│  │     ├─ ReplyMeetingQuestionRequest.php
│  │     ├─ StoreMeetingQuestionRequest.php
│  │     ├─ StoreMeetingRequest.php
│  │     ├─ StoreUserRequest.php
│  │     ├─ UpdateMeetingRequest.php
│  │     └─ UpdateUserRequest.php
│  ├─ Models
│  │  ├─ Meeting.php
│  │  ├─ MeetingDokumentasi.php
│  │  ├─ MeetingQuestion.php
│  │  └─ User.php
│  ├─ Policies
│  │  └─ MeetingPolicy.php
│  ├─ Providers
│  │  └─ AppServiceProvider.php
│  └─ View
│     └─ Components
│        ├─ AppLayout.php
│        └─ GuestLayout.php
├─ artisan
├─ bootstrap
│  ├─ app.php
│  ├─ cache
│  │  ├─ packages.php
│  │  └─ services.php
│  └─ providers.php
├─ composer.json
├─ composer.lock
├─ config
│  ├─ app.php
│  ├─ auth.php
│  ├─ cache.php
│  ├─ database.php
│  ├─ filesystems.php
│  ├─ logging.php
│  ├─ mail.php
│  ├─ purifier.php
│  ├─ queue.php
│  ├─ services.php
│  └─ session.php
├─ database
│  ├─ factories
│  │  └─ UserFactory.php
│  ├─ migrations
│  │  ├─ 0001_01_01_000000_create_users_table.php
│  │  ├─ 0001_01_01_000001_create_cache_table.php
│  │  ├─ 0001_01_01_000002_create_jobs_table.php
│  │  ├─ 2024_01_01_000000_add_surat_undangan_to_meetings_table.php
│  │  ├─ 2026_02_10_070841_add_role_to_users_table.php
│  │  ├─ 2026_02_10_072331_create_meetings_table.php
│  │  ├─ 2026_02_10_072826_create_meeting_questions_table.php
│  │  ├─ 2026_03_05_033916_add_username_to_users_table.php
│  │  ├─ 2026_03_05_044849_make_email_nullable_in_users_table.php
│  │  ├─ 2026_03_09_053348_fix_meetings_foreign_keys_null_on_delete.php
│  │  ├─ 2026_03_10_025756_add_name_snapshot_to_meetings_table.php
│  │  ├─ 2026_03_10_025757_add_name_snapshot_to_meeting_questions_table.php
│  │  └─ 2026_04_06_003443_create_meeting_dokumentasi_table.php
│  └─ seeders
│     └─ DatabaseSeeder.php
├─ package-lock.json
├─ package.json
├─ phpunit.xml
├─ postcss.config.js
├─ public
│  ├─ .htaccess
│  ├─ favicon.ico
│  ├─ images
│  │  └─ logo-diskominfo.png
│  ├─ index.php
│  ├─ js
│  │  └─ tinymce
│  │     ├─ CHANGELOG.md
│  │     ├─ icons
│  │     │  └─ default
│  │     │     └─ icons.min.js
│  │     ├─ langs
│  │     │  └─ README.md
│  │     ├─ license.md
│  │     ├─ models
│  │     │  └─ dom
│  │     │     └─ model.min.js
│  │     ├─ notices.txt
│  │     ├─ plugins
│  │     │  ├─ accordion
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ advlist
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ anchor
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ autolink
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ autoresize
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ autosave
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ charmap
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ code
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ codesample
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ directionality
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ emoticons
│  │     │  │  ├─ js
│  │     │  │  │  ├─ emojiimages.js
│  │     │  │  │  ├─ emojiimages.min.js
│  │     │  │  │  ├─ emojis.js
│  │     │  │  │  └─ emojis.min.js
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ fullscreen
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ help
│  │     │  │  ├─ js
│  │     │  │  │  └─ i18n
│  │     │  │  │     └─ keynav
│  │     │  │  │        ├─ ar.js
│  │     │  │  │        ├─ bg-BG.js
│  │     │  │  │        ├─ bg_BG.js
│  │     │  │  │        ├─ ca.js
│  │     │  │  │        ├─ cs.js
│  │     │  │  │        ├─ da.js
│  │     │  │  │        ├─ de.js
│  │     │  │  │        ├─ el.js
│  │     │  │  │        ├─ en.js
│  │     │  │  │        ├─ es.js
│  │     │  │  │        ├─ eu.js
│  │     │  │  │        ├─ fa.js
│  │     │  │  │        ├─ fi.js
│  │     │  │  │        ├─ fr-FR.js
│  │     │  │  │        ├─ fr_FR.js
│  │     │  │  │        ├─ he-IL.js
│  │     │  │  │        ├─ he_IL.js
│  │     │  │  │        ├─ hi.js
│  │     │  │  │        ├─ hr.js
│  │     │  │  │        ├─ hu-HU.js
│  │     │  │  │        ├─ hu_HU.js
│  │     │  │  │        ├─ id.js
│  │     │  │  │        ├─ it.js
│  │     │  │  │        ├─ ja.js
│  │     │  │  │        ├─ kk.js
│  │     │  │  │        ├─ ko-KR.js
│  │     │  │  │        ├─ ko_KR.js
│  │     │  │  │        ├─ ms.js
│  │     │  │  │        ├─ nb-NO.js
│  │     │  │  │        ├─ nb_NO.js
│  │     │  │  │        ├─ nl.js
│  │     │  │  │        ├─ pl.js
│  │     │  │  │        ├─ pt-BR.js
│  │     │  │  │        ├─ pt-PT.js
│  │     │  │  │        ├─ pt_BR.js
│  │     │  │  │        ├─ pt_PT.js
│  │     │  │  │        ├─ ro.js
│  │     │  │  │        ├─ ru.js
│  │     │  │  │        ├─ sk.js
│  │     │  │  │        ├─ sl-SI.js
│  │     │  │  │        ├─ sl_SI.js
│  │     │  │  │        ├─ sv-SE.js
│  │     │  │  │        ├─ sv_SE.js
│  │     │  │  │        ├─ th-TH.js
│  │     │  │  │        ├─ th_TH.js
│  │     │  │  │        ├─ tr.js
│  │     │  │  │        ├─ uk.js
│  │     │  │  │        ├─ vi.js
│  │     │  │  │        ├─ zh-CN.js
│  │     │  │  │        ├─ zh-TW.js
│  │     │  │  │        ├─ zh_CN.js
│  │     │  │  │        └─ zh_TW.js
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ image
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ importcss
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ insertdatetime
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ link
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ lists
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ media
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ nonbreaking
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ pagebreak
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ preview
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ quickbars
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ save
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ searchreplace
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ table
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ visualblocks
│  │     │  │  └─ plugin.min.js
│  │     │  ├─ visualchars
│  │     │  │  └─ plugin.min.js
│  │     │  └─ wordcount
│  │     │     └─ plugin.min.js
│  │     ├─ skins
│  │     │  ├─ content
│  │     │  │  ├─ dark
│  │     │  │  │  ├─ content.js
│  │     │  │  │  └─ content.min.css
│  │     │  │  ├─ default
│  │     │  │  │  ├─ content.js
│  │     │  │  │  └─ content.min.css
│  │     │  │  ├─ document
│  │     │  │  │  ├─ content.js
│  │     │  │  │  └─ content.min.css
│  │     │  │  ├─ tinymce-5
│  │     │  │  │  ├─ content.js
│  │     │  │  │  └─ content.min.css
│  │     │  │  ├─ tinymce-5-dark
│  │     │  │  │  ├─ content.js
│  │     │  │  │  └─ content.min.css
│  │     │  │  └─ writer
│  │     │  │     ├─ content.js
│  │     │  │     └─ content.min.css
│  │     │  └─ ui
│  │     │     ├─ oxide
│  │     │     │  ├─ content.inline.js
│  │     │     │  ├─ content.inline.min.css
│  │     │     │  ├─ content.js
│  │     │     │  ├─ content.min.css
│  │     │     │  ├─ skin.js
│  │     │     │  ├─ skin.min.css
│  │     │     │  ├─ skin.shadowdom.js
│  │     │     │  └─ skin.shadowdom.min.css
│  │     │     ├─ oxide-dark
│  │     │     │  ├─ content.inline.js
│  │     │     │  ├─ content.inline.min.css
│  │     │     │  ├─ content.js
│  │     │     │  ├─ content.min.css
│  │     │     │  ├─ skin.js
│  │     │     │  ├─ skin.min.css
│  │     │     │  ├─ skin.shadowdom.js
│  │     │     │  └─ skin.shadowdom.min.css
│  │     │     ├─ tinymce-5
│  │     │     │  ├─ content.inline.js
│  │     │     │  ├─ content.inline.min.css
│  │     │     │  ├─ content.js
│  │     │     │  ├─ content.min.css
│  │     │     │  ├─ skin.js
│  │     │     │  ├─ skin.min.css
│  │     │     │  ├─ skin.shadowdom.js
│  │     │     │  └─ skin.shadowdom.min.css
│  │     │     └─ tinymce-5-dark
│  │     │        ├─ content.inline.js
│  │     │        ├─ content.inline.min.css
│  │     │        ├─ content.js
│  │     │        ├─ content.min.css
│  │     │        ├─ skin.js
│  │     │        ├─ skin.min.css
│  │     │        ├─ skin.shadowdom.js
│  │     │        └─ skin.shadowdom.min.css
│  │     ├─ themes
│  │     │  └─ silver
│  │     │     └─ theme.min.js
│  │     ├─ tinymce.d.ts
│  │     └─ tinymce.min.js
│  └─ robots.txt
├─ README.md
├─ resources
│  ├─ css
│  │  ├─ app.css
│  │  └─ auth.css
│  ├─ js
│  │  ├─ app.js
│  │  ├─ bootstrap.js
│  │  ├─ modules
│  │  │  ├─ animations.js
│  │  │  ├─ flash.js
│  │  │  ├─ modal.js
│  │  │  ├─ qa.js
│  │  │  ├─ server-search.js
│  │  │  └─ table-filter.js
│  │  └─ pages
│  │     ├─ dashboard.js
│  │     ├─ edit.js
│  │     ├─ meetings.js
│  │     ├─ show.js
│  │     └─ users.js
│  ├─ js.zip
│  └─ views
│     ├─ auth
│     │  ├─ confirm-password.blade.php
│     │  ├─ forgot-password.blade.php
│     │  ├─ login.blade.php
│     │  ├─ register.blade.php
│     │  ├─ reset-password.blade.php
│     │  └─ verify-email.blade.php
│     ├─ components
│     │  ├─ application-logo.blade.php
│     │  ├─ auth-session-status.blade.php
│     │  ├─ danger-button.blade.php
│     │  ├─ dropdown-link.blade.php
│     │  ├─ dropdown.blade.php
│     │  ├─ input-error.blade.php
│     │  ├─ input-label.blade.php
│     │  ├─ modal.blade.php
│     │  ├─ nav-link.blade.php
│     │  ├─ primary-button.blade.php
│     │  ├─ responsive-nav-link.blade.php
│     │  ├─ secondary-button.blade.php
│     │  └─ text-input.blade.php
│     ├─ dashboard.blade.php
│     ├─ layouts
│     │  ├─ app.blade.php
│     │  ├─ guest.blade.php
│     │  └─ navigation.blade.php
│     ├─ meetings
│     │  ├─ create.blade.php
│     │  ├─ edit.blade.php
│     │  ├─ index.blade.php
│     │  ├─ pdf.blade.php
│     │  └─ show.blade.php
│     └─ users
│        ├─ create.blade.php
│        ├─ edit.blade.php
│        └─ index.blade.php
├─ route('login')
├─ routes
│  ├─ auth.php
│  ├─ console.php
│  └─ web.php
├─ tailwind.config.js
├─ tests
│  ├─ Feature
│  │  ├─ Auth
│  │  │  ├─ AuthenticationTest.php
│  │  │  ├─ EmailVerificationTest.php
│  │  │  ├─ PasswordConfirmationTest.php
│  │  │  ├─ PasswordResetTest.php
│  │  │  ├─ PasswordUpdateTest.php
│  │  │  └─ RegistrationTest.php
│  │  └─ ExampleTest.php
│  ├─ TestCase.php
│  └─ Unit
│     └─ ExampleTest.php
└─ vite.config.js

```