<?php
/**
 * td_translate.php
 * no td_util loaded, no access to settings
 */
global $td_translation_map_user, $td_translation_map;


/**
 * @since Newsmag 1.5
 * use mb_strtolower to obtain UTF8 lowercases etc
 * @see http://php.net/manual/en/function.mb-strtoupper.php
 * @see http://php.net/manual/en/function.mb-strtolower.php
 *
 * for Capitalization of first letter, not yet decided on: http://stackoverflow.com/questions/2517947/ucfirst-function-for-multibyte-character-encodings
 */



$td_translation_map = array(
    //header search
    'View all results' => __('View all results', TD_THEME_NAME),
    'No results' => __('No results', TD_THEME_NAME),

    'Home' => __('Home', TD_THEME_NAME),

    //mobile menu
    'CLOSE' => __('CLOSE', TD_THEME_NAME),

    //title tag
    'Page' => __('Page', TD_THEME_NAME),


    //blocks
    'All' => __('All', TD_THEME_NAME),
    'By' => __('By', TD_THEME_NAME),
    'Load more' => __('Load more', TD_THEME_NAME),

    //breadcrumbs
    'View all posts in' => __('View all posts in', TD_THEME_NAME),
    'Tags' => __('Tags', TD_THEME_NAME),

    //article / page
    'Previous article' => __('Previous article', TD_THEME_NAME),
    'Next article' => __('Next article', TD_THEME_NAME),
    'Authors' => __('Authors', TD_THEME_NAME),
    'Author' => __('Author', TD_THEME_NAME),
    'RELATED ARTICLES' => __('RELATED ARTICLES', TD_THEME_NAME),   //on Newspaper 4 it was: SIMILAR ARTICLES
    'MORE FROM AUTHOR' => __('MORE FROM AUTHOR', TD_THEME_NAME),
    'VIA' => __('VIA', TD_THEME_NAME),   //on Newspaper4 it was lowercase
    'SOURCE' => __('SOURCE', TD_THEME_NAME), //on Newspaper4 it was lowercase
    'TAGS' => __('TAGS', TD_THEME_NAME),
    'SHARE' => __('SHARE', TD_THEME_NAME),
    'Continue' => __('Continue', TD_THEME_NAME),
    'Read more' => __('Read more', TD_THEME_NAME),

    //comments


    'Name:' => __('Name:', TD_THEME_NAME),
    'Email:' => __('Email:', TD_THEME_NAME),
    'Website:' => __('Website:', TD_THEME_NAME),
    'Comment:' => __('Comment:', TD_THEME_NAME),
    'LEAVE A REPLY' => __('LEAVE A REPLY', TD_THEME_NAME),  //on Newspaper4 it was lowercase
    'Post Comment' => __('Post Comment', TD_THEME_NAME),
    'Cancel reply' => __('Cancel reply', TD_THEME_NAME),
    'Reply' => __('Reply', TD_THEME_NAME),
    'Log in to leave a comment' => __('Log in to leave a comment', TD_THEME_NAME),
    'NO COMMENTS' => __('NO COMMENTS', TD_THEME_NAME),
    '1 COMMENT' => __('1 COMMENT', TD_THEME_NAME),
    'COMMENTS' => __('COMMENTS', TD_THEME_NAME),
    'Your comment is awaiting moderation' => __('Your comment is awaiting moderation', TD_THEME_NAME),


    //review
    'REVIEW OVERVIEW' => __('REVIEW OVERVIEW', TD_THEME_NAME),  //on Newspaper4 it was lowercase
    'SUMMARY' => __('SUMMARY', TD_THEME_NAME),  //on Newspaper4 it was lowercase
    'OVERALL SCORE' => __('OVERALL SCORE', TD_THEME_NAME),

    //404
    'Ooops... Error 404' => __('Ooops... Error 404', TD_THEME_NAME),
    "Sorry, but the page you are looking for doesn_t exist." => __("Sorry, but the page you are looking for doesn't exist.", TD_THEME_NAME),
    'You can go to the' => __('You can go to the', TD_THEME_NAME),
    'HOMEPAGE' => __('HOMEPAGE', TD_THEME_NAME),


    'OUR LATEST POSTS' => __('OUR LATEST POSTS', TD_THEME_NAME),

    //author page title atribute
    'Posts by' => __('Posts by', TD_THEME_NAME),
    'POSTS' => __('POSTS', TD_THEME_NAME),


    'Posts tagged with' => __('Posts tagged with', TD_THEME_NAME),
    'Tag' => __('Tag', TD_THEME_NAME),

    //archives
    'Daily Archives:' => __('Daily Archives:', TD_THEME_NAME),
    'Monthly Archives:' => __('Monthly Archives:', TD_THEME_NAME),
    'Yearly Archives:' => __('Yearly Archives:', TD_THEME_NAME),
    'Archives' => __('Archives', TD_THEME_NAME),


    //homepage
    'LATEST ARTICLES' => __('LATEST ARTICLES', TD_THEME_NAME),

    //search page
    'search results' => __('search results', TD_THEME_NAME),
    'Search' => __('Search', TD_THEME_NAME),
    "If you_re not happy with the results, please do another search" => __("If you're not happy with the results, please do another search", TD_THEME_NAME),

    //footer widget
    'Contact us' => __('Contact us', TD_THEME_NAME),

    //footer instagram
    'Follow us on Instagram' => __('Follow us on Instagram', TD_THEME_NAME),

    //pagination
    'Page %CURRENT_PAGE% of %TOTAL_PAGES%' => __('Page %CURRENT_PAGE% of %TOTAL_PAGES%', TD_THEME_NAME),
    'Next' => __('Next', TD_THEME_NAME),
    'Prev' => __('Prev', TD_THEME_NAME),
    'Back' => __('Back', TD_THEME_NAME),


    'No results for your search' => __('No results for your search', TD_THEME_NAME),
    'No posts to display' => __('No posts to display', TD_THEME_NAME),

    //modal window
    'LOG IN'  => __('LOG IN', TD_THEME_NAME),
    'Sign in / Join'  => __('Sign in / Join', TD_THEME_NAME),
    'Sign in' => __('Sign in', TD_THEME_NAME),
    'Sign up' => __('Sign up', TD_THEME_NAME),
    'Join' => __('Join', TD_THEME_NAME),
    'Log In'  => __('Log In', TD_THEME_NAME),
    'REGISTER'  => __('REGISTER', TD_THEME_NAME),
    'Welcome!' => __('Welcome!', TD_THEME_NAME),
    'Log into your account' => __('Log into your account', TD_THEME_NAME),
    'Password recovery' => __('Password recovery', TD_THEME_NAME),
    'Send My Pass'  => __('Send My Pass', TD_THEME_NAME),
    'Forgot your password?'  => __('Forgot your password?', TD_THEME_NAME),
    'Please wait...'  => __('Please wait...', TD_THEME_NAME),
    'User or password incorrect!'  => __('User or password incorrect!', TD_THEME_NAME),
    'Email or username incorrect!'  => __('Email or username incorrect!', TD_THEME_NAME),
    'Email incorrect!'  => __('Email incorrect!', TD_THEME_NAME),
    'User or email already exists!'  => __('User or email already exists!', TD_THEME_NAME),
    'Please check your email (index or spam folder), the password was sent there.'  => __('Please check your email (index or spam folder), the password was sent there.', TD_THEME_NAME),
    'Email address not found!'  => __('Email address not found!', TD_THEME_NAME),
    'Your password is reset, check your email.'  => __('Your password is reset, check your email.', TD_THEME_NAME),
    'Welcome! Log into your account' => __('Welcome! Log into your account', TD_THEME_NAME),
    'Register for an account' => __('Register for an account', TD_THEME_NAME),
    'Recover your password' => __('Recover your password', TD_THEME_NAME),
    'your username' => __('your username', TD_THEME_NAME),
    'your password' => __('your password', TD_THEME_NAME),
    'your email' => __('your email', TD_THEME_NAME),
    'A password will be e-mailed to you.' => __('A password will be e-mailed to you.', TD_THEME_NAME),
    'Logout' => __('Logout', TD_THEME_NAME),

    //social counters
    'Like' => __('Like', TD_THEME_NAME),
    'Likes' => __('Likes', TD_THEME_NAME),
    'Fans' => __('Fans', TD_THEME_NAME),
    'Follow' => __('Follow', TD_THEME_NAME),
    'Followers' => __('Followers', TD_THEME_NAME),
    'Subscribe' => __('Subscribe', TD_THEME_NAME),
    'Subscribers' => __('Subscribers', TD_THEME_NAME),

    //more article box
    'MORE STORIES' => __('MORE STORIES', TD_THEME_NAME),

    //filter drop down options on category page
    'Latest' => __('Latest', TD_THEME_NAME),
    'Featured posts' => __('Featured posts', TD_THEME_NAME),
    'Most popular' => __('Most popular', TD_THEME_NAME),
    '7 days popular' => __('7 days popular', TD_THEME_NAME),
    'By review score' => __('By review score', TD_THEME_NAME),
    'Random' => __('Random', TD_THEME_NAME),

    'Trending Now' => __('Trending Now', TD_THEME_NAME),

    //used in Popular Category widget (td_block_popular_categories.php file)
    'POPULAR CATEGORY' => __('POPULAR CATEGORY', TD_THEME_NAME),
    'POPULAR POSTS' => __('POPULAR POSTS', TD_THEME_NAME),
    'EDITOR PICKS' => __('EDITOR PICKS', TD_THEME_NAME),
    'ABOUT US' => __('ABOUT US', TD_THEME_NAME),
    'FOLLOW US' => __('FOLLOW US', TD_THEME_NAME),
    'EVEN MORE NEWS' => __('EVEN MORE NEWS', TD_THEME_NAME),


	//magnific popup
    'Previous (Left arrow key)' => __('Previous (Left arrow key)', TD_THEME_NAME),
    'Next (Right arrow key)' => __('Next (Right arrow key)', TD_THEME_NAME),
    '%curr% of %total%' => __('%curr% of %total%', TD_THEME_NAME),
    'The content from %url% could not be loaded.' => __('The content from %url% could not be loaded.', TD_THEME_NAME),
    'The image #%curr% could not be loaded.' => __('The image #%curr% could not be loaded.', TD_THEME_NAME),

    //blog
    'Blog' => __('Blog', TD_THEME_NAME),
    'Share on Facebook' => __('Share on Facebook', TD_THEME_NAME),
    'Tweet on Twitter' => __('Tweet on Twitter', TD_THEME_NAME),

    'Featured' => __('Featured', TD_THEME_NAME),
    'All time popular' => __('All time popular', TD_THEME_NAME),

    'More' => __('More', TD_THEME_NAME),
    'Register' => __('Register', TD_THEME_NAME),

    'of' => __('of', TD_THEME_NAME),

    //exchange currencies
    'Euro Member Countries' => __('Euro Member Countries', TD_THEME_NAME),
    'Australian Dollar' => __('Australian Dollar', TD_THEME_NAME),
    'Bulgarian Lev' => __('Bulgarian Lev', TD_THEME_NAME),
    'Brazilian Real' => __('Brazilian Real', TD_THEME_NAME),
    'Canadian Dollar' => __('Canadian Dollar', TD_THEME_NAME),
    'Swiss Franc' => __('Swiss Franc', TD_THEME_NAME),
    'Chinese Yuan Renminbi' => __('Chinese Yuan Renminbi', TD_THEME_NAME),
    'Czech Republic Koruna' => __('Czech Republic Koruna', TD_THEME_NAME),
    'Danish Krone' => __('Danish Krone', TD_THEME_NAME),
    'British Pound' => __('British Pound', TD_THEME_NAME),
    'Hong Kong Dollar' => __('Hong Kong Dollar', TD_THEME_NAME),
    'Croatian Kuna' => __('Croatian Kuna', TD_THEME_NAME),
    'Hungarian Forint' => __('Hungarian Forint', TD_THEME_NAME),
    'Indonesian Rupiah' => __('Indonesian Rupiah', TD_THEME_NAME),
    'Israeli Shekel' => __('Israeli Shekel', TD_THEME_NAME),
    'Indian Rupee' => __('Indian Rupee', TD_THEME_NAME),
    'Japanese Yen' => __('Japanese Yen', TD_THEME_NAME),
    'Korean (South) Won' => __('Korean (South) Won', TD_THEME_NAME),
    'Mexican Peso' => __('Mexican Peso', TD_THEME_NAME),
    'Malaysian Ringgit' => __('Malaysian Ringgit', TD_THEME_NAME),
    'Norwegian Krone' => __('Norwegian Krone', TD_THEME_NAME),
    'New Zealand Dollar' => __('New Zealand Dollar', TD_THEME_NAME),
    'Philippine Peso' => __('Philippine Peso', TD_THEME_NAME),
    'Polish Zloty' => __('Polish Zloty', TD_THEME_NAME),
    'Romanian (New) Leu' => __('Romanian (New) Leu', TD_THEME_NAME),
    'Russian Ruble' => __('Russian Ruble', TD_THEME_NAME),
    'Swedish Krona' => __('Swedish Krona', TD_THEME_NAME),
    'Singapore Dollar' => __('Singapore Dollar', TD_THEME_NAME),
    'Thai Baht' => __('Thai Baht', TD_THEME_NAME),
    'Turkish Lira' => __('Turkish Lira', TD_THEME_NAME),
    'United States Dollar' => __('United States Dollar', TD_THEME_NAME),
    'South African Rand' => __('South African Rand', TD_THEME_NAME),

);



//read the user translations
$td_translation_map_user = td_util::get_option('td_translation_map_user');


//the custom translation function
function __td($td_string, $td_domain = '') {
    global $td_translation_map_user, $td_translation_map;
    if (!empty($td_translation_map_user[$td_string])) {   //return the user translation
        return stripslashes($td_translation_map_user[$td_string]);
    } elseif (!empty($td_translation_map[$td_string])) { //return the default translation or from MO file
        return $td_translation_map[$td_string];
    } else {
        //no translation detected - return the string
        return $td_string;
    }
}


//echo custom translation function
function _etd($td_string, $td_domain = '') {
    echo __td($td_string, $td_domain);
}

