<?php
require_once $global['systemRootPath'] . 'objects/playlist.php';
$playlist = new PlayList($playlist_id);
$playlistVideos = PlayList::getVideosFromPlaylist($playlist_id);
?>
<div class="playlist-nav">
    <nav class="navbar navbar-inverse">
        <ul class="nav navbar-nav">
            <li class="navbar-header">
                <a>
                    <h3 class="nopadding">
                        <?php
                        echo $playlist->getName();
                        ?>
                    </h3>
                    <small>
                        <?php
                        echo ($playlist_index + 1), "/", count($playlistVideos), " ", __("Videos");
                        ?>
                    </small>
                </a>
            </li>
        </ul>
    </nav>
    <nav class="navbar navbar-inverse playlistList">
        <ul class="nav navbar-nav">
            <?php
            $count = 0;
            foreach ($playlistVideos as $value) {
                $class = "";
                $indicator = $count + 1;
                if ($count == $playlist_index) {
                    $class .= " active";
                    $indicator = '<span class="fa fa-play text-danger"></span>';
                }
                ?>
                <li class="<?php echo $class; ?>">
                    <a href="<?php echo $global['webSiteRootURL']; ?>program/<?php echo $playlist_id; ?>/<?php echo $count."/{$value["channelName"]}/".urlencode($playlist->getName())."/{$value['clean_title']}"; ?>" title="<?php echo $value['title']; ?>" class="videoLink row">
                        <div class="col-md-1 col-sm-1 col-xs-1">
                            <?php echo $indicator; ?>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3 nopadding">
                            <?php
                            if (($value['type'] !== "audio") && ($value['type'] !== "linkAudio")) {
                                $img = "{$global['webSiteRootURL']}videos/{$value['filename']}.jpg";
                                $img_portrait = ($value['rotation'] === "90" || $value['rotation'] === "270") ? "img-portrait" : "";
                            } else {
                                $img = "{$global['webSiteRootURL']}view/img/audio_wave.jpg";
                                $img_portrait = "";
                            }
                            ?>
                            <img src="<?php echo $img; ?>" alt="<?php echo $value['title']; ?>" class="img-responsive <?php echo $img_portrait; ?>  rotate<?php echo $value['rotation']; ?>" height="130" itemprop="thumbnail" />

                            <span itemprop="thumbnailUrl" content="<?php echo $img; ?>" />
                            <span itemprop="contentURL" content="<?php echo $global['webSiteRootURL'], $catLink, "video/", $value['clean_title']; ?>" />
                            <span itemprop="embedURL" content="<?php echo $global['webSiteRootURL'], "videoEmbeded/", $value['clean_title']; ?>" />
                            <span itemprop="uploadDate" content="<?php echo $value['created']; ?>" />

                            <?php
                            if ($value['type'] !== 'pdf' && $value['type'] !== 'article' && $value['type'] !== 'serie') {
                                ?>
                                <span class="duration"><?php echo Video::getCleanDuration($value['duration']); ?></span>
                                <div class="progress" style="height: 3px; margin-bottom: 2px;">
                                    <div class="progress-bar progress-bar-danger" role="progressbar" style="width: <?php echo $value['progress']['percent'] ?>%;" aria-valuenow="<?php echo $value['progress']['percent'] ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div> 
                                <?php
                            }
                            ?>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8 videosDetails">
                            <div class="text-uppercase row"><strong itemprop="name" class="title"><?php echo $value['title']; ?></strong></div>
                            <div class="details row" itemprop="description">
                                <div>
                                    <span class="<?php echo @$value['iconClass']; ?>"></span>
                                </div>

                                <?php
                                if (empty($advancedCustom->doNotDisplayViews)) {
                                    ?> 
                                    <div>
                                        <strong class=""><?php echo number_format($value['views_count'], 0); ?></strong> <?php echo __("Views"); ?>
                                    </div>
                                    <?php
                                }
                                ?>

                            </div>
                        </div>
                    </a>
                </li>
                <?php
                $count++;
            }
            ?>
        </ul>
    </nav>
</div>