<?php
// lang/en.php - English localization file
return [
    // Header & Navigation
    'title_home'        => 'Emotional Support Space | Emotions by Mail',
    'title_paper'       => 'Paper Letter Service',
    'title_digital'     => 'Anonymous Email Support',
    'nav_paper'         => 'Paper Letters',
    'nav_digital'       => 'Email Support',
    'nav_about'         => 'About Us',

    // Home Page Hero Section
    'seo_title'         => 'Emotional Support Service',
    'hero_greeting'     => 'Truly Warm Emotional Support',
    'hero_subtitle'     => 'Heartfelt paper letters and a safe space to vent via email whenever you need support, care, or simply to know that you are not alone.',
    'choose_format'     => 'Choose the format that suits you right now:',
    'btn_paper'         => 'Get a Paper Letter',
    'btn_digital'       => 'Vent via Email',

    // Paper Page (SEO-Optimized Block)
    'paper_seo_title'   => 'Paper Letter Service • Tactile Warmth',
    'paper_title'       => 'A Real Letter Hand-Sealed with Wax You Can Hold',
    'paper_desc'        => 'Tangible support and a heartfelt gift for you and your loved ones. A beautifully crafted card on heavy designer paper with meaningful, gentle words, sealed with a real wax stamp, and delivered straight to the mailbox. Send a single special letter for a meaningful date or set up a weekly subscription of caring messages.',
    'btn_order_paper'   => 'Order a Letter',

    // Modal Window & Launch Notification (For Paper/Pre-order)
    'welcome_seo_title'       => 'Paper Letter Service • Tactile Warmth',
    'welcome_heading'         => 'A Real Letter Hand-Sealed with Wax You Can Hold',
    'welcome_subtitle'        => 'Tangible support and a heartfelt gift for you and your loved ones. A beautifully crafted card on heavy designer paper with meaningful, gentle words, sealed with a real wax stamp, and delivered straight to the mailbox. Send a single special letter for a meaningful date or set up a weekly subscription of caring messages.',
    'btn_notify_launch'       => 'Notify Me on Launch Day',
'welcome_bonus_text_1'      => '💡 The service is under development.
We are finalizing the last details. Leave your email, and we will notify you on opening day.',
    'welcome_bonus_text'      => '🎁 Subscribe now and get a <strong>personal discount</strong> on your first order on launch day',

    'modal_title'             => 'Be Among the First',
    'modal_desc'              => 'Leave your email, and we will write to you on launch day, along with a personal discount for your first order.',
    'input_email_placeholder' => 'Your Email',
    'btn_submit'              => 'Notify Me',

    'modal_success_title'     => 'Thank You!',
    'modal_success_desc1'     => 'You will be among the first to know about our launch.',
    'modal_success_desc2'     => 'We sent a confirmation to:',
    'modal_success_spam'      => 'Please check your inbox<br>(and your Spam folder if it does not arrive shortly).',

    'modal_already_title'     => 'You Are Already Subscribed!',
    'modal_already_desc'      => 'We will send a notification to your email as soon as everything is ready.',

    // Digital Page (SEO-Optimized Block)
    'digital_seo_title' => 'Anonymous Email Support • Digital Warmth',
    'digital_title'     => 'A Safe Space to Anonymously Vent via Email',
    'digital_desc'      => 'An online emotional venting format for anyone who needs to release anxiety, unload heavy thoughts, and gain clarity. Write freely about anything troubling you — we listen attentively without judgment, help you see the situation from a fresh perspective, and support you in finding inner peace.',
    'btn_order_digital' => 'Start Subscription',

    // Emotions Section
    'emotions_heading'  => 'How are you feeling right now?',
    'emotion_neutral'   => 'Hard to define',
    'neutral_subject'   => '[Dialogue] Feeling confused',
    'neutral_body'      => "Hi.\nIt's hard for me to understand what I'm feeling right now, but I need to vent...",

    // Additional Neutral Button "I just want to vent"
    'btn_just_vent'     => 'I just want to vent',
    'vent_subject'      => '[Vent] Want to share my thoughts',
    'vent_body'         => "Hi!\nI just need to vent and unload my thoughts...",

    'emotions_list' => [
        // 5 Positive
        ['icon' => '✨', 'name' => 'Inspiration', 'type' => 'positive', 'subject' => '[Inspiration] Want to share', 'body' => "Hi!\nI feel an emotional lift right now and want to share..."],
        ['icon' => '🙏', 'name' => 'Gratitude', 'type' => 'positive', 'subject' => '[Gratitude] Bright thoughts', 'body' => "Hi!\nI want to share a sense of gratitude for..."],
        ['icon' => '🌱', 'name' => 'Hope', 'type' => 'positive', 'subject' => '[Hope] Believing in the best', 'body' => "Hi.\nHope is slowly returning. I feel that..."],
        ['icon' => '🕊️', 'name' => 'Peace', 'type' => 'positive', 'subject' => '[Peace] Calm thoughts', 'body' => "Hi.\nIt's quiet inside right now. I want to write this down..."],
        ['icon' => '😊', 'name' => 'Joy', 'type' => 'positive', 'subject' => '[Joy] Great moment', 'body' => "Hi!\nSomething good happened, I want to express this joy..."],
        
        // 5 Difficult
        ['icon' => '😰', 'name' => 'Anxiety', 'type' => 'negative', 'subject' => '[Anxiety] Need to calm down', 'body' => "Hi.\nI feel very anxious right now. I'm worried about..."],
        ['icon' => '💔', 'name' => 'Sadness', 'type' => 'negative', 'subject' => '[Sadness] Heavy heart', 'body' => "Hi.\nI feel sad right now. It feels like..."],
        ['icon' => '🔥', 'name' => 'Anger', 'type' => 'negative', 'subject' => '[Anger] Venting steam', 'body' => "Hi.\nI am incredibly angry and annoyed by..."],
        ['icon' => '🌧️', 'name' => 'Loneliness', 'type' => 'negative', 'subject' => '[Loneliness] Need to talk', 'body' => "Hi.\nI have no one to say this to, but I feel..."],
        ['icon' => '🔋', 'name' => 'Fatigue', 'type' => 'negative', 'subject' => '[Fatigue] Running out of energy', 'body' => "Hi.\nI am terribly tired of..."],
    ],
    
    // Copy Fallback Section
    'fallback_text'   => 'If the buttons do not open your mail client, you can copy the address and paste it into the "To:" field manually:',
    'btn_copy_email'  => 'Copy e-mail address',
    'toast_copied'    => 'Address copied to clipboard!',

    // Digital FAQ Section (For Email Page)
    'faq_title' => 'Frequently Asked Questions',
    'faq_q1' => 'How does emotion selection work?',
    'faq_a1' => 'By clicking on the corresponding emotion, a pre-filled email draft opens in your mail client. All you have to do is type your message and press "Send".',
    'faq_q2' => 'What if the button does not open my email?',
    'faq_a2' => 'You can use the "Copy e-mail address" button above, open your preferred email provider (Gmail, Outlook, etc.), and send a message manually to digital@emotionsbymail.com.',
    'faq_q3' => 'How fast will I receive a reply?',
    'faq_a3' => 'We process all emails in order of arrival. Usually, a reply arrives within 24 hours.',
    'faq_q4' => 'Is it completely confidential?',
    'faq_a4' => 'Yes, all correspondence is strictly anonymous and protected. We never share your data with third parties or publish your letters.',
    'faq_q5' => 'Is this service truly free?',
    'faq_a5' => 'Yes, absolutely! You can freely express any emotions using the "I just want to vent" button. Replying to your own emails creates a continuous stream of thoughts — your personal safe space diary that helps you see situations from a new perspective and gain clarity.',
    'faq_q6' => 'Can I get a reply from a real person?',
    'faq_a6' => 'Yes, we offer a "Support over a Cup of Coffee" format. This is a caring dialogue with a specialist who avoids giving rigid advice, helping you hear yourself through insightful questions.<br><br>One session includes a series of 5 emails. The cost is symbolic — the price of a cup of coffee (€5).<br><br><a href="https://www.buymeacoffee.com/emotionsbymail" class="bmc-button-wrapper" target="_blank">☕ Buy me a coffee (€5)</a>',

    // Paper FAQ Section (For Paper Page)
    'paper_faq_title' => 'Frequently Asked Questions',
    'paper_faq' => [
        [
            'q' => 'What do the letters look like and what is included?',
            'a' => 'Each letter is an aesthetic card made of thick designer paper with custom artwork and a gentle message. It is packaged in a quality envelope and hand-sealed with a real wax stamp.'
        ],
        [
            'q' => 'Can I send a letter to myself?',
            'a' => 'Absolutely! Many of our subscribers choose this format as a personal self-care ritual. Finding a beautiful envelope in your mailbox instead of bills and ads is a special moment of pause and joy.'
        ],
        [
            'q' => 'How does the subscription and letter series work?',
            'a' => 'You can choose a single letter for a specific date or subscribe to a weekly series (e.g., 4 letters delivered once a week). This provides steady, gentle emotional support over time.'
        ],
        [
            'q' => 'How are the letters delivered?',
            'a' => 'We send the letters via standard mail directly to the physical mailbox at the specified address. No need to visit the post office — the envelope will simply arrive in the mailbox.'
        ],
    ],

    // Footer
    'footer_about'      => 'Truly warm and caring emotional support through real paper letters and emails.',
    'footer_sections'   => 'Sections:',
    'footer_contact'    => 'Contact us:',
    'footer_disclaimer' => 'Important: This service provides emotional support but does not replace professional psychotherapy or emergency medical assistance. If you are in a severe crisis, please reach out to local emergency services or lifelines.',
];