<?php /* Template Name: Intro Register Template */ ?>

<?php get_header(); ?>

<?php
$breadcrumb = array();
array_push($breadcrumb, ['url' => '#!', 'text' => jcci_translate_text('入会のメリット＆入会のお手続き')]);
?>

    <div id="post-<?php the_ID(); ?>" <?php post_class('article page-intro-register'); ?>>
        <div class="page--header" style="background-image: url(<?= jcci_get_main_visual_background() ?>);">
            <h1 class="page--title"><?php the_title(); ?></h1>
        </div>
        <div class="page--breadcrumb">
            <div class="container">
                <?php jcci_render_breadcrumb($breadcrumb); ?>
            </div>
        </div>
        <div class="page--content">
        	<div class="container">
        		<div class="row">
        			<div class="col-lg-9 col-md-8 page--content-left">
                        <?php edit_post_link(); ?>

                        <?php if (have_posts()): while (have_posts()) : the_post(); ?>

                            <?php the_content(); ?>

                            <?php endwhile; ?>

                        <?php else: ?>

                            <p><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></p>

                        <?php endif; ?>

                        <?php if (0) { // TODO: we will using this if content in editor is broken ?>
        				<div id="joining-benefit" class="sec-1">
                            <h3>入会のメリット＆入会のお手続き</h3>
                            <div class="sec-1-1">
                                <h4>入会のメリット</h4>
                                <div class="sec-content">
                                    <div class="row">
                                        <div class="mb-4 col-md-6 col-sm-12">
                                            <div class="border-bottom same-height">
                                                <h3 class="number">01.</h3>
                                                <h5>より良い投資・事業環境の実現のために</h5>
                                                <p>会員企業の声をベトナム政府や諸機関に届け、交渉することが可能です。</p>
                                                <p>
                                                    ・ビジネスフォーラム、日越共同イニシアティブ等への参加<br>
                                                    ・会員企業が抱える諸課題について意見書・要望書を提出<br>
                                                    ・ベトナムの規定や法律等の改正の際の提言等
                                                </p>
                                            </div>
                                        </div>
                                        <div class="mb-4 col-md-6 col-sm-12">
                                            <div class="border-bottom same-height">
                                                <h3 class="number">02.</h3>
                                                <h5>情報共有・情報入手のために</h5>
                                                <p>
                                                    ・所属部会の会合に参加することで、会員企業と直接交流・情報共有ができます。<br>
                                                    ・メールやホームページで、各種情報やセミナー、視察会等の案内を幅広く入手できます。
                                                </p>
                                            </div>
                                    </div>
                                    <div class="row">
                                        </div>
                                        <div class="mb-4 col-md-6 col-sm-12">
                                            <div class="border-bottom same-height">
                                                <h3 class="number">03.</h3>
                                                <h5>生活の輪を広げるために</h5>
                                                <p>医療・健康関連等の講演会やスポーツ・文化交流イベント等に参加でき、当地での生活の輪を広げることができます。また、企画運営にも関わることができます</p>
                                            </div>
                                        </div>
                                        <div class="mb-4 col-md-6 col-sm-12">
                                            <div class="border-bottom same-height">
                                                <h3 class="number">04.</h3>
                                                <h5>より早い安全対策のために</h5>
                                                <p>緊急事態発生時など、JBAVの情報配信システムにより早期に情報を入手できます</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-4 col-md-6 col-sm-12">
                                            <div class="border-bottom same-height">
                                                <h3 class="number">05.</h3>
                                                <h5>日越両国の親善のために</h5>
                                                <p>日越両国間の親善活動に参加できます。</p>
                                            </div>
                                        </div>
                                        <div class="mb-4 col-md-6 col-sm-12">
                                            <div class="border-bottom same-height">
                                                <h3 class="number">06.</h3>
                                                <h5>その他</h5>
                                                <p>加盟レストラン、ショップ、ホテル、病院等のご利用時に、割引等のサービスを受けられるJBAVカードを利用できます。</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="sec-1-2">
                                <h4>入会のお手続き </h4>
                                <div class="sec-content">
                                    <h5>入会申請書をご提出いただき理事会の承認を経てご入会いただくことになります。</h5>
                                    <div class="table-responsive-sm">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>Step 1</td>
                                                    <td>入会申請書入手</td>
                                                    <td>事務局でご入手いただくか、 ホームページからダウンロードして下さい。</td>
                                                </tr>
                                                <tr>
                                                    <td>Step 2</td>
                                                    <td>入会申請書記入</td>
                                                    <td>会員2社(うち1社は希望商工部会理事会社)の推薦が 必要です。</td>
                                                </tr>
                                                <tr>
                                                    <td>Step 3</td>
                                                    <td>入会申請書提出</td>
                                                    <td>事務局にご持参ください。</td>
                                                </tr>
                                                <tr>
                                                    <td>Step 4</td>
                                                    <td>入会申請書確認</td>
                                                    <td>事務局から推薦会員に確認させていただきます。</td>
                                                </tr>
                                                <tr>
                                                    <td>Step 5</td>
                                                    <td>理事会の承認</td>
                                                    <td>毎月第4金曜日開催の理事会で承認します。</td>
                                                </tr>
                                                <tr>
                                                    <td>Step 6</td>
                                                    <td>ご入会</td>
                                                    <td>理事会承認の翌月1日からご入会いただきます。</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <br>
                                    <h5>入会申請書</h5>
                                    <p><i class="zmdi zmdi-collection-pdf"></i> ダウンロード</p>
                                    <br>
                                    <h5>お問い合わせ先</h5>
                                    <p><strong>TEL:</strong>  +84-24-2220-9907/8</p>
                                    <p><strong>FAX:</strong>  +84-24-2220-9909</p>
                                    <p><strong>Email:</strong>  jcci-info@jcci.vn</p>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div id="member-condition" class="sec-2">
                            <h3>会費&会員条件</h3>
                            <div class="sec-2-1">
                                <h4>会費（2019年度）</h4>
                                <p>(A．出資者基準)　＋　(B．人数基準) にて構成</p>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th class="text-primary">A.出資者基準</th>
                                            <th class="text-primary text-right">VND年額</th>
                                        </tr>
                                        <tr>
                                            <td>・東証・大証一部上場またはそれに準じる</td>
                                            <td class="text-right">36,000,000</td>
                                        </tr>
                                        <tr>
                                            <td>・東証・大証二部上場またはそれに準じる</td>
                                            <td class="text-right">30,000,000</td>
                                        </tr>
                                        <tr>
                                            <td>・それ以外</td>
                                            <td class="text-right">15,000,000</td>
                                        </tr>
                                        <tr>
                                            <th class="text-primary">B.人数基準</th>
                                            <th class="text-primary text-right">VND年額</th>
                                        </tr>
                                        <tr>
                                            <td>・1～2人</td>
                                            <td class="text-right">2,500,000</td>
                                        </tr>
                                        <tr>
                                            <td>・3～10人</td>
                                            <td class="text-right">5,000,000</td>
                                        </tr>
                                        <tr>
                                            <td>・11～30人</td>
                                            <td class="text-right">7,500,000</td>
                                        </tr>
                                        <tr>
                                            <td>・31～50人</td>
                                            <td class="text-right">10,000,000</td>
                                        </tr>
                                        <tr>
                                            <td>・51人以上</td>
                                            <td class="text-right">12,500,000</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <h5>注</h5>
                                <div class="border-bottom mb-3">
                                    <h3 class="number">01.</h3>
                                    <p>東証・大証一部上場またはそれに準ずる：<br>上場していないが、資本金規模などが上場企業に相当する企業、法人、機関など。</p>
                                </div>
                                <div class="border-bottom mb-3">
                                    <h3 class="number">02.</h3>
                                    <p>人数基準：<br>毎年1月1日時点、新規入会の場合は入会時点での日本人の常駐派遣者人数。<br>現地採用日本人、日本政府機関のプロジェクト派遣専門家、建設工事現場派遣員などは含まない。<br>現地採用の代表者を含む。</p>
                                </div>
                                <div class="border-bottom mb-3">
                                    <h3 class="number">03.</h3>
                                    <p>.年度途中に入会した会員については、入会月から3月までの加入月数をもとに、次の計算式によって算出された金額を初年度の年会費  とする。<br>        ※計算式：（(Ａ．出資者基準)　＋(Ｂ．人数基準)）÷１２×加入月数<br>なお、上記計算式により金額の1,000 VND未満に端数が生じた場合には、100 VNDの位を四捨五入した金額とする。</p>
                                    <p>*入会金は不要です。<br>*活動年度は4月～3月で、途中入会の場合、会費は月割りになります。<br>*年度当初またはご入会時、一括前納となります。<br>  年度途中でご退会の場合、会費の返金はできません。</p>
                                </div>
                            </div>
                            <br>
                            <div class="sec-2-2">
                                <h4>会員とは</h4>
                                <div class="mb-4 row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="border-bottom same-height">
                                            <h3 class="number">01.</h3>
                                            <p> ベトナム社会主義共和国に事務所等の拠点を有する、ベトナム政府に登録済みの日本法人もしくは日系法人。</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="border-bottom same-height">
                                            <h3 class="number">02.</h3>
                                            <p>その他、理事会が会員として加入を許可した法人。</p>
                                        </div>
                                    </div>
                                </div>
                                <p>※詳細は事務局までお問い合わせください。</p>
                            </div>
                            <br>
                            <div class="sec-2-3">
                                <h4>商工部会</h4>
                                <p>現在、6つの商工部会があり、会員はいずれかの商工部会に所属していただきます</p>
                                <div class="row">
                                    <div class="col-md-2 col-sm-6 col-xs-12">
                                        <div class="border-bottom">
                                            <h3 class="number">01.</h3>
                                            <p class="f-size-16">貿易部会</p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6 col-xs-12">
                                        <div class="border-bottom">
                                            <h3 class="number">02.</h3>
                                            <p class="f-size-16">建設部会</p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6 col-xs-12">
                                        <div class="border-bottom">
                                            <h3 class="number">03.</h3>
                                            <p class="f-size-16">工業部会</p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6 col-xs-12">
                                        <div class="border-bottom">
                                            <h3 class="number">04.</h3>
                                            <p class="f-size-16">金融保険部会</p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6 col-xs-12">
                                        <div class="border-bottom">
                                            <h3 class="number">05.</h3>
                                            <p class="f-size-16">サービス等部会</p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-6 col-xs-12">
                                        <div class="border-bottom">
                                            <h3 class="number">06.</h3>
                                            <p class="f-size-16">運輸部会</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
        			</div>
        			<div class="col-lg-3 col-md-4 page--content-right">
        				<ul class="p-0 m-0 list-unstyled right-menu">
        					<li class="active smooth-scroll"><a href="#joining-benefit"><?= jcci_translate_text('入会のメリット＆入会のお手続き') ?></a></li>
        					<li><a href="#member-condition" class="smooth-scroll"><?= jcci_translate_text('会費&会員条件') ?></a></li>
        				</ul>
        			</div>
        		</div>
        	</div>
        </div>
    </div>

    <?php //the_content(); ?>

                <?php //edit_post_link(); ?>

<?php //get_sidebar(); ?>

<?php get_footer(); ?>
