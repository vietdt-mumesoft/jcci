<?php
/** 
 * Template for the list item store 
 * Only work with Store related Post Type like:
 * - Restaurants
 * - Hotel & Apart
 * - Shop & Golf & Other
 * 
 * @package JCCI Card
*/

$post_id = get_the_ID();
$post_thumbnail_url = get_the_post_thumbnail_url($post_id, 'full');
$name_jp = get_the_title();
$name_en = get_field('name_en', $post_id);
$address = get_field('address', $post_id);

$tel = get_field('tel', $post_id);
$tel_input_type = $tel ? $tel['input_type'] : '';
$tel_text = $tel ? $tel['text'] : '';
$tel_html = $tel ? $tel['html'] : '';
if ($tel_input_type === 'none') {
    $tel = ''; // for empty tel
}

$website = get_field('website', $post_id);
$sale_offers = get_post_meta(get_the_ID(), '_store_repeater', true);

$contact_person = get_field('contact_person', $post_id);
$contact_person_address = $contact_person['address'];
$contact_person_tel = $contact_person['tel'];
$contact_person_tel_input_type = $contact_person_tel ? $contact_person_tel['input_type'] : '';
$contact_person_tel_text = $contact_person_tel ? $contact_person_tel['text'] : '';
$contact_person_tel_html = $contact_person_tel ? $contact_person_tel['html'] : '';
if ($contact_person_tel_input_type === 'none') {
    $contact_person_tel = ''; // for empty tel
}

$is_jcch = $contact_person['is_jcch'];
$is_jcci = $contact_person['is_jcci'];

$file_attachment = get_field('file_attachment', $post_id);

?> 
<div class="block-items">
    <div class="block-items-left">
        <div class="image">
            <div class="image-inner">
                <img src="<?php echo $post_thumbnail_url; ?>">
            </div>
        </div>
        <div class="title">
            <h3 class="japan"> <?php echo $name_jp; ?> </h3>
            <h4 class="eng"> <?php echo $name_en; ?> </h4>
        </div>
    </div>
    <div class="block-items-right">
        <div class="promotion">
            <ul>
                <?php if (!empty($sale_offers) && is_array($sale_offers)) : ?>
                    <?php foreach ($sale_offers as $offer) : ?> 
                        <li>
                            <span class="pr1"><?php echo $offer['pr1']; ?></span>
                            <span class="pr2"><?php echo $offer['pr2']; ?></span>
                            <span class="pr3"><p><?php echo $offer['pr3']; ?></p></span>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
        <div class="detail">
            <ul>
                <?php if (!empty($address)) : ?>
                    <li>
                        <label class="add">Address :</label><?php echo $address; ?>
                    </li>
                <?php endif; ?>

                <?php if (!empty($tel)) : ?>
                    <li>
                        <label class="tel">TEL :</label>
                        <?php if ($tel_input_type === 'text') : ?>
                            <a class="tel" 
                                title="Call now" 
                                alt="Call now" href="tel:<?php echo $tel_text; ?>"
                            >
                                <?php echo $tel_text; ?>
                            </a>
                        <?php elseif ($tel_input_type === 'html') : ?>
                            <?php echo $tel_html; ?>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>

                <?php if (!empty($website)) : ?>
                    <li>
                        <label class="web">Website :</label>
                        <a target="_bank" 
                            title="Go to visited website <?php echo $name_en; ?>" 
                            alt="Go to visited website <?php echo $name_en; ?>" 
                            href="<?php echo $website; ?>"
                        >
                            <?php echo $website; ?>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (!empty($file_attachment)) : ?>
                    <li class="download">
                        <a target="_bank" 
                        href="<?php echo $file_attachment['url']; ?>" 
                        <?php if (jcci_card_is_image_extension($file_attachment)) : ?>
                            class="fancybox image"
                        <?php endif; ?>
                    > 
                        Download</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <hr>
        <div class="contact">
            <div class="contact1">
                <span>Contact Person</span>
            </div>
            <div class="contact2">
                <ul>
                    <?php if (!empty($contact_person['name'])) : ?>
                        <li>
                            <label class="name">Name :</label> <?php echo $contact_person['name']; ?>
                        </li>
                    <?php endif; ?>

                    <?php if (!empty($contact_person_tel)) : ?>
                        <li>
                            <label class="tel">TEL :</label>
                            <?php if ($contact_person_tel_input_type === 'text') : ?>
                                <a class="tel" 
                                    title="Call now" 
                                    alt="Call now" 
                                    href="tel:<?php echo $contact_person_tel; ?>"
                                >
                                    <?php echo $contact_person_tel_text; ?>
                                </a>
                            <?php elseif ($contact_person_tel_input_type === 'html') : ?>
                                <?php echo $contact_person_tel_html; ?>
                            <?php endif; ?>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="contact3">
                <?php if ($is_jcch) : ?>
                    <span>JCCH</span>
                <?php endif; ?>
                <?php if ($is_jcci) : ?>
                    <span>JCCI</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>