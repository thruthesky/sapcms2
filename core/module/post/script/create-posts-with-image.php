<?php
$id = "test-forum-with-photo";
if ( ! $config = post_config($id) ) {
    $config = post_config()->set('id', $id)->set('name', 'Test Forum With Photo')->save();
}
for ( $i=0; $i<10; $i++ ) {
    $option = [
        'idx_config' => $config->get('idx'),
        'title' => "Title $i",
        'content' => "Content $i",
    ];
    $post = post_data()->newPost($option);
}

$option = [
    'idx_config' => $config->get('idx'),
    'title' => 'Philadelphia Newlyweds Join Nude Bicyclists in Wedding Photos',
    'content' => "If newlyweds Ross Cohen, 31, and Blair Delson Cohen, 29, have kids in the future, they might have to wait a few years before they show their offspring all of their wedding pictures.
Along with the traditional photos with their wedding party and family, the Philadelphia couple’s wedding photo album will forever include photos of them right in the middle of thousands of nude cyclists.
Sarah Michelle Geller Posts Wedding Pic With Freddie Prinze on Anniversary",
];
$post = post_data()->newPost($option);
$data = $post->attachFile(PATH_INSTALL . "/tmp/wedding.jpg");
if ( $data ) {
    echo "file attached : " . $data->get('idx');
}
else {
    echo "fail attachment is failed";
}

$option = [
    'idx_config' => $config->get('idx'),
    'title'=>"Yahoo Global News Anchor",
    'content' => "Katie Couric is an award winning journalist and TV personality, well-known cancer activist and New York Times best-selling author.
As Yahoo Global News Anchor, Couric anchors live events and conducts groundbreaking interviews with major newsmakers and global game changers. Couric also hosts the popular weekly explainer series",
];
$post = post_data()->newPost($option);
$data = $post->attachFile(PATH_INSTALL . "/tmp/woman.jpg");


$option = [
    'idx_config' => $config->get('idx'),
    'title'=>"Fan Bingbing made $21 million last year: Who is she?",
    'content' => "Forbes’ has released its list of the top paid actresses in 2015 and for the most part its pretty standard. Jennifer Lawrence, aka America’s sweetheart, came in first, followed by Scarlett Johansson and Melissa McCarthy. The fourth highest paid actress, however, is a surprise. Fan Bingbing, a 33 year-old Chinese actress, producer and singer, has earned $21 million pre-tax over the past 12 months.
Americans might recognize Fan from her small role in X-Men: Days of Future Past, but for the most part her earnings come from China’s growing national film market. Fan is so successful in her home country that Barbie recently released a doll modeled after her in Shanghai.
So who is Fan Bingbing and how did she make more money than Jennifer Aniston, Angelina Jolie and Meryl Streep last year?",
];
$post = post_data()->newPost($option);
$data = $post->attachFile(PATH_INSTALL . "/tmp/fan1.jpg");
$data = $post->attachFile(PATH_INSTALL . "/tmp/fan2.jpg");
$data = $post->attachFile(PATH_INSTALL . "/tmp/fan3.jpg");



$option = [
    'idx_config' => $config->get('idx'),
    'title'=>"Red Hat Enterprise Linux 7.2 Beta brings improved container support",
    'content' => "Red Hat has announced the release of Red Hat Enterprise Linux (RHEL) 7.2 beta. In addition to the typical updates, the release will make it easier for businesses to build and deploy Linux containers. This release also brings some refreshment to the RHEL desktop with rebasing it to GNOME 3.14 desktop and package GNOME Software.
no flash
Tested: How Flash destroys your browser's performance
It’s a memory hog -- and we’ve got the numbers to prove it.
READ NOW
The beta improves the platform's underlying container support infrastructure, including OverlayFS and user namespaces. These improvements will assist customers in containerizing existing (traditional) applications and at the same time develop new applications based on a microservices style architecture.
What users won’t find in the RHEL 7.2 Beta is Red Hat Enterprise Linux Atomic Host, their container-optimized host platform because it is updated on a rapid 6-week sprint cycle.
Some of the enhancements that come with the beta include (from the press release)",
];
$post = post_data()->newPost($option);
$data = $post->attachFile(PATH_INSTALL . "/tmp/redhat.jpg");




$option = [
    'idx_config' => $config->get('idx'),
    'title'=>"15 Unattractive Celebs with Beautiful Children",
    'content' => "Not all celebrities are beautiful and with perfectly symmetrical faces! Some of them truly have beautifully symmetrical faces, but others… Let’s say they owe everything to their charisma. And we are not saying that they are less valuable than their pretty colleagues! It’s just how it is. However, new generations are here to prove us wrong. That’s why some of these celebs have surprisingly beautiful kids! And even though we never expected such beauty, these kids are really a gift to this planet. Take a look at this list we made to show you how unattractive celebs can have really beautiful children!",
];
$post = post_data()->newPost($option);
$data = $post->attachFile(PATH_INSTALL . "/tmp/fam.jpg");


$option = [
    'idx_config' => $config->get('idx'),
    'title'=>"Survey Findings Highlight the Staggering Toll of Chronic Pain",
    'content' => "It’s not right, but for many people with chronic pain, being slapped with an unfair label is not exactly uncommon. After all, there are a lot of misconceptions about chronic pain — sufferers know this more than anyone. And according to the results from a new survey from Yahoo Health and Silver Hill Hospital, at least half of chronic pain sufferers polled believe others associate the above words with those who have unrelenting pain.
Chronic pain is a widespread problem in the U.S., affecting at least 100 million American men and women, according to the Institute of Medicine. And it takes a serious toll. The Yahoo Health/Silver Hill survey, which included 900 people who self-identified as having experienced serious, continual pain during the past six months or longer, showed that even though pain may not take your life, it can certainly take your",
];
$post = post_data()->newPost($option);
$data = $post->attachFile(PATH_INSTALL . "/tmp/alone.jpg");





$content =<<<EOH
“I can’t seem to lose this belly,” my friend Bill told me over Mexican food the other night. “I’m running 15 miles a week, I’m cutting calories everywhere I can, and nothing. The only thing I’m not giving up is my margaritas!” Then he scooped a bit of salt off the rim before throwing back a splash of his drink.

“The margaritas might be the problem,” I told him. “Not because of the calories. Because of the salt.”

In fact, a new study has linked obesity and sodium intake so closely that cutting down on salt might be the absolute best way to shed belly fat, fast. For every extra gram of salt you eat in a day — that’s a mere ⅕ of a teaspoon, or about what you’ll find in one of those tiny salt packets from the soup shop — your risk of obesity climbs by 25 percent, according to a study at Queen Mary University in London. Researchers speculate that sodium alters our metabolism, changing the way in which we absorb fat.

And that’s really bad news. From our packaged snacks to the food we order in restaurants, the modern American diet is saltier than Amy Schumer’s pillow talk. American men eat 4,243 mg of sodium a day, about double what experts recommend, while women average about 3,000 mg daily. And most of the salt we eat comes not from our own salt shaker, but from restaurants and packaged foods. The best way to seize control: Cook more at home, which will automatically cut your salt intake in half. That’s a lot of weight loss, just for eating a lot of delicious food. Here are some of the easiest ways to trim your belly, adapted from the new Zero Belly Cookbook. And see how adding low-sodium foods into your diet is one of the 14 Ways to Lose Your Belly in 14 Days!
EOH;

$option = [
    'idx_config' => $config->get('idx'),
    'title'=>"The #1 Reason You're Not Losing Belly Fat",
    'content' => $content,
];
$post = post_data()->newPost($option);
$data = $post->attachFile(PATH_INSTALL . "/tmp/burger.jpg");


$option = [
    'idx_config' => $config->get('idx'),
    'title'=>"Why Taking a Break Could Actually Improve Your Relationship",
    'content' => "Jaime and Joe had one of those summertime romances that only exist in New York, filled with drinks that turn into lengthy dinners, evenings out with friends, and even trips to the gym that somehow still felt incredibly romantic. But for Jaime, who was a late 20-something working in public relations at the time, the relationship wasn’t just a summer fling. It felt like the start of something serious, until she sensed Joe pulling away. And then came the dreaded phone call. He couldn’t commit. He was overwhelmed with work.",
];
$post = post_data()->newPost($option);
$data = $post->attachFile(PATH_INSTALL . "/tmp/boygirl.jpg");


$option = [
    'idx_config' => $config->get('idx'),
    'title'=>"18 Fittest VMA Bodies",
    'content' => "Wild and risque fashion choices are a given at MTV’s Video Music Awards, and this year’s were no exception. Miley Cyrus, Nicki Minaj, Britney Spears, and others hit the red carpet showing plenty of skin (and in Miley’s case, not much else).
And who can really blame them? Most stars work hard to sculpt their tight, toned physiques. So we rounded up some of the fittest celebs at this year’s VMAs — plus the insider scoop on the stars’ hot-body secrets. In no particular order…",
];
$post = post_data()->newPost($option);
$data = $post->attachFile(PATH_INSTALL . "/tmp/girl.jpg");


