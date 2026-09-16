<?php
/*
 * Daily verse pools — one per page.
 * Usage: $verse = get_daily_verse('devotionals');
 *        echo '"' . $verse['text'] . '" — ' . $verse['ref'];
 *
 * The verse changes automatically each day (day-of-year modulo pool size).
 */

function get_daily_verse(string $page): array
{
    static $pools = null;
    if ($pools === null) {
        $pools = $GLOBALS['_verse_pools'] ?? [];
    }

    $pool = $pools[$page] ?? [];
    if (empty($pool)) {
        return ['text' => '', 'ref' => ''];
    }

    $index = (int) date('z') % count($pool);
    return $pool[$index];
}

/* ─── POOLS ─── */

$GLOBALS['_verse_pools'] = [

    /* ── Homepage (logged in) ── */
    'home_member' => [
        ['text' => 'The Lord is my strength and my shield; my heart trusts in him, and he helps me.', 'ref' => 'Psalm 28:7'],
        ['text' => 'I can do all things through Christ who strengthens me.', 'ref' => 'Philippians 4:13'],
        ['text' => 'The Lord is near to all who call on him, to all who call on him in truth.', 'ref' => 'Psalm 145:18'],
        ['text' => 'Trust in the Lord with all your heart and lean not on your own understanding.', 'ref' => 'Proverbs 3:5'],
        ['text' => 'Come to me, all you who are weary and burdened, and I will give you rest.', 'ref' => 'Matthew 11:28'],
        ['text' => 'The Lord will fight for you; you need only to be still.', 'ref' => 'Exodus 14:14'],
        ['text' => 'Be strong and courageous. Do not be afraid, for the Lord your God will be with you wherever you go.', 'ref' => 'Joshua 1:9'],
        ['text' => 'Delight yourself in the Lord, and he will give you the desires of your heart.', 'ref' => 'Psalm 37:4'],
        ['text' => 'But those who hope in the Lord will renew their strength.', 'ref' => 'Isaiah 40:31'],
        ['text' => 'And my God will meet all your needs according to the riches of his glory in Christ Jesus.', 'ref' => 'Philippians 4:19'],
        ['text' => 'The joy of the Lord is your strength.', 'ref' => 'Nehemiah 8:10'],
        ['text' => 'He who began a good work in you will carry it on to completion.', 'ref' => 'Philippians 1:6'],
    ],

    /* ── Homepage (guest / hero) ── */
    'home_guest' => [
        ['text' => 'For where two or three gather in my name, there am I with them.', 'ref' => 'Matthew 18:20'],
        ['text' => 'Draw near to God, and he will draw near to you.', 'ref' => 'James 4:8'],
        ['text' => 'Come, let us sing for joy to the Lord; let us shout aloud to the Rock of our salvation.', 'ref' => 'Psalm 95:1'],
        ['text' => 'The Lord is close to the brokenhearted and saves those who are crushed in spirit.', 'ref' => 'Psalm 134:18'],
        ['text' => 'Ask and it will be given to you; seek and you will find.', 'ref' => 'Matthew 7:7'],
        ['text' => 'For I know the plans I have for you, declares the Lord, plans to prosper you and not to harm you.', 'ref' => 'Jeremiah 29:11'],
        ['text' => 'Cast all your anxiety on him because he cares for you.', 'ref' => '1 Peter 5:7'],
        ['text' => 'Taste and see that the Lord is good; blessed is the one who takes refuge in him.', 'ref' => 'Psalm 34:8'],
        ['text' => 'I am the light of the world. Whoever follows me will never walk in darkness.', 'ref' => 'John 8:12'],
        ['text' => 'The Lord bless you and keep you; the Lord make his face shine on you and be gracious to you.', 'ref' => 'Numbers 6:24–25'],
    ],

    /* ── Prayer Requests ── */
    'prayer_requests' => [
        ['text' => 'Do not be anxious about anything, but in every situation, by prayer and petition, with thanksgiving, present your requests to God.', 'ref' => 'Philippians 4:6'],
        ['text' => 'The prayer of a righteous person is powerful and effective.', 'ref' => 'James 5:16'],
        ['text' => 'Call to me and I will answer you and tell you great and unsearchable things you do not know.', 'ref' => 'Jeremiah 33:3'],
        ['text' => 'If my people, who are called by my name, will humble themselves and pray, I will hear from heaven.', 'ref' => '2 Chronicles 7:14'],
        ['text' => 'Whatever you ask for in prayer, believe that you have received it, and it will be yours.', 'ref' => 'Mark 11:24'],
        ['text' => 'You will seek me and find me when you seek me with all your heart.', 'ref' => 'Jeremiah 29:13'],
        ['text' => 'The Lord hears his people when they call to him for help.', 'ref' => 'Psalm 34:17'],
        ['text' => 'Devote yourselves to prayer, being watchful and thankful.', 'ref' => 'Colossians 4:2'],
        ['text' => 'Pray in the Spirit on all occasions with all kinds of prayers and requests.', 'ref' => 'Ephesians 6:18'],
        ['text' => 'Your Father in heaven gives good gifts to those who ask him.', 'ref' => 'Matthew 7:11'],
    ],

    /* ── Devotionals ── */
    'devotionals' => [
        ['text' => 'Your word is a lamp for my feet, a light on my path.', 'ref' => 'Psalm 119:105'],
        ['text' => 'All Scripture is God-breathed and is useful for teaching, rebuking, correcting and training in righteousness.', 'ref' => '2 Timothy 3:16'],
        ['text' => 'I will meditate on all your works and consider all your mighty deeds.', 'ref' => 'Psalm 77:12'],
        ['text' => 'The entrance of your words gives light; it gives understanding to the simple.', 'ref' => 'Psalm 119:130'],
        ['text' => 'Man shall not live by bread alone, but by every word that comes from the mouth of God.', 'ref' => 'Matthew 4:4'],
        ['text' => 'I have hidden your word in my heart that I might not sin against you.', 'ref' => 'Psalm 119:11'],
        ['text' => 'The grass withers and the flowers fall, but the word of our God endures forever.', 'ref' => 'Isaiah 40:8'],
        ['text' => 'Whatever you do, work at it with all your heart, as working for the Lord.', 'ref' => 'Colossians 3:23'],
        ['text' => 'Be still, and know that I am God.', 'ref' => 'Psalm 46:10'],
        ['text' => 'My sheep listen to my voice; I know them, and they follow me.', 'ref' => 'John 10:27'],
    ],

    /* ── Fellowship ── */
    'fellowship' => [
        ['text' => 'And let us consider how we may spur one another on toward love and good deeds.', 'ref' => 'Hebrews 10:24'],
        ['text' => 'How good and pleasant it is when God\'s people live together in unity!', 'ref' => 'Psalm 133:1'],
        ['text' => 'Two are better than one, because they have a good return for their labor.', 'ref' => 'Ecclesiastes 4:9'],
        ['text' => 'A friend loves at all times, and a brother is born for a time of adversity.', 'ref' => 'Proverbs 17:17'],
        ['text' => 'Carry each other\'s burdens, and in this way you will fulfill the law of Christ.', 'ref' => 'Galatians 6:2'],
        ['text' => 'Clothe yourselves with compassion, kindness, humility, gentleness and patience.', 'ref' => 'Colossians 3:12'],
        ['text' => 'Accept one another, then, just as Christ accepted you.', 'ref' => 'Romans 15:7'],
        ['text' => 'Let us not become weary in doing good, for at the proper time we will reap a harvest.', 'ref' => 'Galatians 6:9'],
        ['text' => 'Above all, love each other deeply, because love covers over a multitude of sins.', 'ref' => '1 Peter 4:8'],
        ['text' => 'So whether you eat or drink or whatever you do, do it all for the glory of God.', 'ref' => '1 Corinthians 10:31'],
    ],

    /* ── Testimonies ── */
    'testimonies' => [
        ['text' => 'Let the redeemed of the Lord tell their story.', 'ref' => 'Psalm 107:2'],
        ['text' => 'I will declare your name to my people; in the assembly I will praise you.', 'ref' => 'Psalm 22:22'],
        ['text' => 'Come and hear, all you who fear God; let me tell you what he has done for me.', 'ref' => 'Psalm 66:16'],
        ['text' => 'They triumphed over him by the blood of the Lamb and by the word of their testimony.', 'ref' => 'Revelation 12:11'],
        ['text' => 'The Lord has done great things for us, and we are filled with joy.', 'ref' => 'Psalm 126:3'],
        ['text' => 'Give thanks to the Lord, for he is good; his love endures forever.', 'ref' => 'Psalm 107:1'],
        ['text' => 'Great is the Lord and most worthy of praise; his greatness no one can fathom.', 'ref' => 'Psalm 145:3'],
        ['text' => 'The Lord is my salvation; whom shall I fear?', 'ref' => 'Psalm 27:1'],
        ['text' => 'Every good and perfect gift is from above, coming down from the Father of the heavenly lights.', 'ref' => 'James 1:17'],
        ['text' => 'This is the day that the Lord has made; let us rejoice and be glad in it.', 'ref' => 'Psalm 118:24'],
    ],

    /* ── Single Testimony page ── */
    'testimony' => [
        ['text' => 'I will praise you, Lord, with all my heart; I will tell of all the marvelous things you have done.', 'ref' => 'Psalm 9:1'],
        ['text' => 'You turned my wailing into dancing; you removed my sackcloth and clothed me with joy.', 'ref' => 'Psalm 30:11'],
        ['text' => 'Give thanks in all circumstances; for this is God\'s will for you.', 'ref' => '1 Thessalonians 5:18'],
        ['text' => 'And we know that in all things God works for the good of those who love him.', 'ref' => 'Romans 8:28'],
        ['text' => 'The Lord is close to the brokenhearted and saves those who are crushed in spirit.', 'ref' => 'Psalm 34:18'],
        ['text' => 'I will give thanks to you, for I am fearfully and wonderfully made.', 'ref' => 'Psalm 139:14'],
        ['text' => 'For great is his love toward us, and the faithfulness of the Lord endures forever.', 'ref' => 'Psalm 136:1'],
        ['text' => 'He who began a good work in you will carry it on to completion.', 'ref' => 'Philippians 1:6'],
        ['text' => 'The Lord has done amazing things for us!', 'ref' => 'Psalm 126:3'],
        ['text' => 'My lips will shout for joy when I sing praise to you — I whom you have delivered.', 'ref' => 'Psalm 71:23'],
    ],

    /* ── Profile ── */
    'profile' => [
        ['text' => 'For we are God\'s handiwork, created in Christ Jesus to do good works.', 'ref' => 'Ephesians 2:10'],
        ['text' => 'Search me, God, and know my heart; test me and know my anxious thoughts.', 'ref' => 'Psalm 139:23'],
        ['text' => 'I will praise you because I am fearfully and wonderfully made.', 'ref' => 'Psalm 139:14'],
        ['text' => 'The Lord will fulfill his purpose for me; your love, O Lord, endures forever.', 'ref' => 'Psalm 138:8'],
        ['text' => 'For I know the plans I have for you, declares the Lord, plans to give you a hope and a future.', 'ref' => 'Jeremiah 29:11'],
        ['text' => 'Let us not grow weary of doing good, for in due season we will reap.', 'ref' => 'Galatians 6:9'],
        ['text' => 'The Lord is my shepherd; I lack nothing.', 'ref' => 'Psalm 23:1'],
        ['text' => 'But seek first the kingdom of God and his righteousness, and all these things will be added to you.', 'ref' => 'Matthew 6:33'],
        ['text' => 'Be strong and courageous. Do not be afraid, for the Lord your God will be with you wherever you go.', 'ref' => 'Joshua 1:9'],
        ['text' => 'I pray that out of his glorious riches he may strengthen you with power through his Spirit.', 'ref' => 'Ephesians 3:16'],
    ],
];
