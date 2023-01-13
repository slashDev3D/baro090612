/**
 * @author https://www.cosmosfarm.com
 */

jQuery(document).ready(function(){
	jQuery('#kboard-first-news-ticker .news-ticker-list').cycle({
        timeout : parseInt(kboard_first_news_ticker_settings.timeout),
		speed   : parseInt(kboard_first_news_ticker_settings.speed),
        fx      : kboard_first_news_ticker_settings.fx,
        next    : kboard_first_news_ticker_settings.next,
        prev    : kboard_first_news_ticker_settings.prev,
        slides  : kboard_first_news_ticker_settings.slides
	});
});