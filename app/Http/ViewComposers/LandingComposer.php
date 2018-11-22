<?
namespace App\Http\ViewComposers;

use Illuminate\View\View;

use App\StaticPage;
use App\StaticContent;
use Auth;
use Log;
use App;

class LandingComposer
{
    public function compose(View $view)
    {
        //Carrousel
        $locale                = App::getLocale();
        $page                  = StaticPage::where('identifier', 'index')->first();
        $img_slider_1          = StaticContent::where('page_id', $page->id)->where('identifier', 'img_slider_1')->first()->content;
        $title_slider_1        = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'title_slider_1')->first()->content;
        $subtitle_slider_1     = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'subtitle_slider_1')->first()->content;
        $paragraph_slider_1    = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'paragraph_slider_1')->first()->content;
        $button_text_slider_1  = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'button_text_slider_1')->first()->content;
        $button_link_slider_1  = StaticContent::where('page_id', $page->id)->where('lang', 'link')->where('identifier', 'button_link_slider_1')->first()->content;
        $img_slider_2          = StaticContent::where('page_id', $page->id)->where('identifier', 'img_slider_2')->first()->content;
        $title_slider_2        = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'title_slider_2')->first()->content;
        $subtitle_slider_2     = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'subtitle_slider_2')->first()->content;
        $paragraph_slider_2    = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'paragraph_slider_2')->first()->content;
        $button_text_slider_2  = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'button_text_slider_2')->first()->content;
        $button_link_slider_2  = StaticContent::where('page_id', $page->id)->where('lang', 'link')->where('identifier', 'button_link_slider_2')->first()->content;
        $img_slider_3          = StaticContent::where('page_id', $page->id)->where('identifier', 'img_slider_3')->first()->content;
        $title_slider_3        = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'title_slider_3')->first()->content;
        $subtitle_slider_3     = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'subtitle_slider_3')->first()->content;
        $paragraph_slider_3    = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'paragraph_slider_3')->first()->content;
        $button_text_slider_3  = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'button_text_slider_3')->first()->content;
        $button_link_slider_3  = StaticContent::where('page_id', $page->id)->where('lang', 'link')->where('identifier', 'button_link_slider_3')->first()->content;
        $img_slider_4          = StaticContent::where('page_id', $page->id)->where('identifier', 'img_slider_4')->first()->content;
        $title_slider_4        = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'title_slider_4')->first()->content;
        $subtitle_slider_4     = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'subtitle_slider_4')->first()->content;
        $paragraph_slider_4    = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'paragraph_slider_4')->first()->content;
        $button_text_slider_4  = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'button_text_slider_4')->first()->content;
        $button_link_slider_4  = StaticContent::where('page_id', $page->id)->where('lang', 'link')->where('identifier', 'button_link_slider_4')->first()->content;
        $img_slider_5          = StaticContent::where('page_id', $page->id)->where('identifier', 'img_slider_5')->first()->content;
        $title_slider_5        = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'title_slider_5')->first()->content;
        $subtitle_slider_5     = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'subtitle_slider_5')->first()->content;
        $paragraph_slider_5    = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'paragraph_slider_5')->first()->content;
        $button_text_slider_5  = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'button_text_slider_5')->first()->content;
        $button_link_slider_5  = StaticContent::where('page_id', $page->id)->where('lang', 'link')->where('identifier', 'button_link_slider_5')->first()->content;
        //About_Section
        $subtitle_grand        = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'subtitle_grand')->first()->content;
        $title_grand           = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'title_grand')->first()->content;
        $paragraph_grand       = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'paragraph_grand')->first()->content;
        $section_title1        = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section_title1')->first()->content;
        $section_title2        = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section_title2')->first()->content;
        $section_title3        = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section_title3')->first()->content;
        $section_paragraph1    = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section_paragraph1')->first()->content;
        $section_paragraph2    = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section_paragraph2')->first()->content;
        $section_paragraph3    = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section_paragraph3')->first()->content;
        //Causes_Section
        $section3_subtitle     = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section3_subtitle')->first()->content;
        $section3_title        = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section3_title')->first()->content;
        $section3_paragraph    = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section3_paragraph')->first()->content;
        //Events
        $section4_subtitle     = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section4_subtitle')->first()->content;
        $section4_title        = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section4_title')->first()->content;
        $section4_paragraph    = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section4_paragraph')->first()->content;
        $section4_subtitle1    = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section4_subtitle1')->first()->content;
        $section4_subtitle2    = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section4_subtitle2')->first()->content;
        $section4_subtitle3    = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section4_subtitle3')->first()->content;
        $section4_subtitle4    = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section4_subtitle4')->first()->content;
        $section4_img1         = StaticContent::where('page_id', $page->id)->where('identifier', 'section4_img1')->first()->content;
        $section4_img2         = StaticContent::where('page_id', $page->id)->where('identifier', 'section4_img2')->first()->content;
        $section4_img3         = StaticContent::where('page_id', $page->id)->where('identifier', 'section4_img3')->first()->content;
        $section4_img4         = StaticContent::where('page_id', $page->id)->where('identifier', 'section4_img4')->first()->content;
        $section4_paragraph1   = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section4_paragraph1')->first()->content;
        $section4_paragraph2   = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section4_paragraph2')->first()->content;
        $section4_paragraph3   = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section4_paragraph3')->first()->content;
        $section4_paragraph4   = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section4_paragraph4')->first()->content;
        $section4_subtitle1_1  = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section4_subtitle1_1')->first()->content;
        $section4_subtitle2_1  = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section4_subtitle2_1')->first()->content;
        $section4_subtitle3_1  = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section4_subtitle3_1')->first()->content;
        $section4_subtitle4_1  = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section4_subtitle4_1')->first()->content;
        $section4_paragraph1_1 = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section4_paragraph1_1')->first()->content;
        $section4_paragraph2_1 = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section4_paragraph2_1')->first()->content;
        $section4_paragraph3_1 = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section4_paragraph3_1')->first()->content;
        $section4_paragraph4_1 = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section4_paragraph4_1')->first()->content;
        $button1_text_section4 = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'button1_text_section4')->first()->content;
        $button1_link_section4 = StaticContent::where('page_id', $page->id)->where('lang', 'link')->where('identifier', 'button1_link_section4')->first()->content;
        $button2_text_section4 = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'button2_text_section4')->first()->content;
        $button2_link_section4 = StaticContent::where('page_id', $page->id)->where('lang', 'link')->where('identifier', 'button2_link_section4')->first()->content;
        //Galery
        $section5_subtitle     = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section5_subtitle')->first()->content;
        $section5_title        = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section5_title')->first()->content;
        $section5_paragraph    = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section5_paragraph')->first()->content;
        $section5_paragraph1   = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section5_paragraph')->first()->content;
        $section5_subtitle2    = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section5_subtitle1')->first()->content;
        $section5_img1         = StaticContent::where('page_id', $page->id)->where('identifier', 'section5_img1')->first()->content;
        $section5_img2         = StaticContent::where('page_id', $page->id)->where('identifier', 'section5_img2')->first()->content;
        $section5_img3         = StaticContent::where('page_id', $page->id)->where('identifier', 'section5_img3')->first()->content;
        $section5_img4         = StaticContent::where('page_id', $page->id)->where('identifier', 'section5_img4')->first()->content;
        $section5_img5         = StaticContent::where('page_id', $page->id)->where('identifier', 'section5_img5')->first()->content;
        $section5_img6         = StaticContent::where('page_id', $page->id)->where('identifier', 'section5_img6')->first()->content;
        $section5_title_img1   = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section5_title_img1')->first()->content;
        $section5_title_img2   = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section5_title_img2')->first()->content;
        $section5_title_img3   = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section5_title_img3')->first()->content;
        $section5_title_img4   = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section5_title_img4')->first()->content;
        $section5_title_img5   = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section5_title_img5')->first()->content;
        $section5_title_img6   = StaticContent::where('page_id', $page->id)->where('lang', $locale)->where('identifier', 'section5_title_img6')->first()->content;
        $view->with(compact('img_slider_1', 'title_slider_1', 'subtitle_slider_1', 'paragraph_slider_1', 'button_text_slider_1', 'button_link_slider_1', 'img_slider_2', 'title_slider_2', 'subtitle_slider_2', 'paragraph_slider_2', 'button_text_slider_2', 'button_link_slider_2', 'img_slider_3', 'title_slider_3', 'subtitle_slider_3', 'paragraph_slider_3', 'button_text_slider_3', 'button_link_slider_3', 'img_slider_4', 'title_slider_4', 'subtitle_slider_4', 'paragraph_slider_4', 'button_text_slider_4', 'button_link_slider_4', 'img_slider_5', 'title_slider_5', 'subtitle_slider_5', 'paragraph_slider_5', 'button_text_slider_5', 'button_link_slider_5', 'subtitle_grand', 'title_grand', 'paragraph_grand', 'section_title1', 'section_title2', 'section_title3', 'section_paragraph1', 'section_paragraph2', 'section_paragraph3', 'section3_subtitle', 'section3_title', 'section3_paragraph', 'section4_subtitle', 'section4_title', 'section4_paragraph', 'section4_subtitle1', 'section4_subtitle2', 'section4_subtitle3', 'section4_subtitle4', 'section4_img1', 'section4_img2', 'section4_img3', 'section4_img4', 'section4_paragraph1', 'section4_paragraph2', 'section4_paragraph3', 'section4_paragraph4', 'section4_subtitle1_1', 'section4_subtitle2_1', 'section4_subtitle3_1', 'section4_subtitle4_1', 'section4_paragraph1_1', 'section4_paragraph2_1', 'section4_paragraph3_1', 'section4_paragraph4_1', 'section4_paragraph1_2', 'section4_paragraph2_2', 'section4_paragraph3_2', 'section4_paragraph4_2', 'button1_text_section4', 'button1_link_section4', 'button2_text_section4', 'button2_link_section4', 'section5_subtitle', 'section5_title', 'section5_paragraph', 'section5_subtitle1', 'section5_img1', 'section5_img2', 'section5_img3', 'section5_img4', 'section5_img5', 'section5_img6', 'section5_title_img1', 'section5_title_img2', 'section5_title_img3', 'section5_title_img4', 'section5_title_img5', 'section5_title_img6'));

    }
}
