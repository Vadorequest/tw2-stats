<?php $this->beginWidget('bootstrap.widgets.BsPanel', array(
    'title' => 'Statistic',
)); ?>

    <ul>
        <li>
            <strong>Beta - zz2 (Expertus)</strong>
            <?php
                $tribes = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('tribe_zz2')
                    ->queryAll();
                $characters = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('character_zz2')
                    ->queryAll();
                $villages = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('village_zz2')
                    ->queryAll();
            ?>
            <ul>
                <li>Last update completed: <?= round((time()-$this->config->last_update_zz2)/60) ?> mins ago.</li>
                <li>Tribes: <?= $tribes[0]['COUNT(*)'] ?></li>
                <li>Players: <?= $characters[0]['COUNT(*)'] ?></li>
                <li>Villages: <?= $villages[0]['COUNT(*)'] ?></li>
            </ul>
        </li>
        <li>
            <strong>Beta - zz3 (Experior)</strong>
            <?php
                $tribes = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('tribe_zz3')
                    ->queryAll();
                $characters = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('character_zz3')
                    ->queryAll();
                $villages = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('village_zz3')
                    ->queryAll();
            ?>
            <ul>
                <li>Last update completed: <?= round((time()-$this->config->last_update_zz3)/60) ?> mins ago.</li>
                <li>Tribes: <?= $tribes[0]['COUNT(*)'] ?></li>
                <li>Players: <?= $characters[0]['COUNT(*)'] ?></li>
                <li>Villages: <?= $villages[0]['COUNT(*)'] ?></li>
            </ul>
        </li>
        <li>
            <strong>En - en1 (Alnwick)</strong>
            <?php
                $tribes = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('tribe_en1')
                    ->queryAll();
                $characters = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('character_en1')
                    ->queryAll();
                $villages = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('village_en1')
                    ->queryAll();
            ?>
            <ul>
                <li>Last update completed: <?= round((time()-$this->config->last_update_en1)/60) ?> mins ago.</li>
                <li>Tribes: <?= $tribes[0]['COUNT(*)'] ?></li>
                <li>Players: <?= $characters[0]['COUNT(*)'] ?></li>
                <li>Villages: <?= $villages[0]['COUNT(*)'] ?></li>
            </ul>
        </li>
        <li>
            <strong>En - en2 (Bastille)</strong>
            <?php
                $tribes = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('tribe_en2')
                    ->queryAll();
                $characters = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('character_en2')
                    ->queryAll();
                $villages = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('village_en2')
                    ->queryAll();
            ?>
            <ul>
                <li>Last update completed: <?= round((time()-$this->config->last_update_en2)/60) ?> mins ago.</li>
                <li>Tribes: <?= $tribes[0]['COUNT(*)'] ?></li>
                <li>Players: <?= $characters[0]['COUNT(*)'] ?></li>
                <li>Villages: <?= $villages[0]['COUNT(*)'] ?></li>
            </ul>
        </li>
        <li>
            <strong>De - de1 (Alnwick)</strong>
            <?php
                $tribes = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('tribe_de1')
                    ->queryAll();
                $characters = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('character_de1')
                    ->queryAll();
                $villages = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('village_de1')
                    ->queryAll();
            ?>
            <ul>
                <li>Last update completed: <?= round((time()-$this->config->last_update_de1)/60) ?> mins ago.</li>
                <li>Tribes: <?= $tribes[0]['COUNT(*)'] ?></li>
                <li>Players: <?= $characters[0]['COUNT(*)'] ?></li>
                <li>Villages: <?= $villages[0]['COUNT(*)'] ?></li>
            </ul>
        </li>
        
        <li>
            <strong>Nl - nl1 (Alnwick)</strong>
            <?php
                $tribes = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('tribe_nl1')
                    ->queryAll();
                $characters = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('character_nl1')
                    ->queryAll();
                $villages = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('village_nl1')
                    ->queryAll();
            ?>
            <ul>
                <li>Last update completed: <?= round((time()-$this->config->last_update_nl1)/60) ?> mins ago.</li>
                <li>Tribes: <?= $tribes[0]['COUNT(*)'] ?></li>
                <li>Players: <?= $characters[0]['COUNT(*)'] ?></li>
                <li>Villages: <?= $villages[0]['COUNT(*)'] ?></li>
            </ul>
        </li>
        <li>
            <strong>Fr - fr1 (Alnwick)</strong>
            <?php
                $tribes = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('tribe_fr1')
                    ->queryAll();
                $characters = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('character_fr1')
                    ->queryAll();
                $villages = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('village_fr1')
                    ->queryAll();
            ?>
            <ul>
                <li>Last update completed: <?= round((time()-$this->config->last_update_fr1)/60) ?> mins ago.</li>
                <li>Tribes: <?= $tribes[0]['COUNT(*)'] ?></li>
                <li>Players: <?= $characters[0]['COUNT(*)'] ?></li>
                <li>Villages: <?= $villages[0]['COUNT(*)'] ?></li>
            </ul>
        </li>
        <li>
            <strong>Pl - pl1 (Alnwick)</strong>
            <?php
                $tribes = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('tribe_pl1')
                    ->queryAll();
                $characters = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('character_pl1')
                    ->queryAll();
                $villages = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('village_pl1')
                    ->queryAll();
            ?>
            <ul>
                <li>Last update completed: <?= round((time()-$this->config->last_update_pl1)/60) ?> mins ago.</li>
                <li>Tribes: <?= $tribes[0]['COUNT(*)'] ?></li>
                <li>Players: <?= $characters[0]['COUNT(*)'] ?></li>
                <li>Villages: <?= $villages[0]['COUNT(*)'] ?></li>
            </ul>
        </li>
        <li>
            <strong>Ru - ru1 (Мир 1)</strong>
            <?php
                $tribes = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('tribe_ru1')
                    ->queryAll();
                $characters = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('character_ru1')
                    ->queryAll();
                $villages = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('village_ru1')
                    ->queryAll();
            ?>
            <ul>
                <li>Last update completed: <?= round((time()-$this->config->last_update_ru1)/60) ?> mins ago.</li>
                <li>Tribes: <?= $tribes[0]['COUNT(*)'] ?></li>
                <li>Players: <?= $characters[0]['COUNT(*)'] ?></li>
                <li>Villages: <?= $villages[0]['COUNT(*)'] ?></li>
            </ul>
        </li>
        
        <li>
            <strong>Br - br1 (Alnwick)</strong>
            <?php
                $tribes = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('tribe_br1')
                    ->queryAll();
                $characters = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('character_br1')
                    ->queryAll();
                $villages = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('village_br1')
                    ->queryAll();
            ?>
            <ul>
                <li>Last update completed: <?= round((time()-$this->config->last_update_br1)/60) ?> mins ago.</li>
                <li>Tribes: <?= $tribes[0]['COUNT(*)'] ?></li>
                <li>Players: <?= $characters[0]['COUNT(*)'] ?></li>
                <li>Villages: <?= $villages[0]['COUNT(*)'] ?></li>
            </ul>
        </li>
        <li>
            <strong>Us - us1 (Alnwick)</strong>
            <?php
                $tribes = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('tribe_us1')
                    ->queryAll();
                $characters = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('character_us1')
                    ->queryAll();
                $villages = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('village_us1')
                    ->queryAll();
            ?>
            <ul>
                <li>Last update completed: <?= round((time()-$this->config->last_update_us1)/60) ?> mins ago.</li>
                <li>Tribes: <?= $tribes[0]['COUNT(*)'] ?></li>
                <li>Players: <?= $characters[0]['COUNT(*)'] ?></li>
                <li>Villages: <?= $villages[0]['COUNT(*)'] ?></li>
            </ul>
        </li>
        <li>
            <strong>Es - es1 (Alnwick)</strong>
            <?php
                $tribes = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('tribe_es1')
                    ->queryAll();
                $characters = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('character_es1')
                    ->queryAll();
                $villages = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('village_es1')
                    ->queryAll();
            ?>
            <ul>
                <li>Last update completed: <?= round((time()-$this->config->last_update_es1)/60) ?> mins ago.</li>
                <li>Tribes: <?= $tribes[0]['COUNT(*)'] ?></li>
                <li>Players: <?= $characters[0]['COUNT(*)'] ?></li>
                <li>Villages: <?= $villages[0]['COUNT(*)'] ?></li>
            </ul>
        </li>
        <li>
            <strong>It - it1 (Alnwick)</strong>
            <?php
                $tribes = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('tribe_it1')
                    ->queryAll();
                $characters = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('character_it1')
                    ->queryAll();
                $villages = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('village_it1')
                    ->queryAll();
            ?>
            <ul>
                <li>Last update completed: <?= round((time()-$this->config->last_update_it1)/60) ?> mins ago.</li>
                <li>Tribes: <?= $tribes[0]['COUNT(*)'] ?></li>
                <li>Players: <?= $characters[0]['COUNT(*)'] ?></li>
                <li>Villages: <?= $villages[0]['COUNT(*)'] ?></li>
            </ul>
        </li>
        <li>
            <strong>Gr - gr1 (Alnwick)</strong>
            <?php
                $tribes = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('tribe_gr1')
                    ->queryAll();
                $characters = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('character_gr1')
                    ->queryAll();
                $villages = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('village_gr1')
                    ->queryAll();
            ?>
            <ul>
                <li>Last update completed: <?= round((time()-$this->config->last_update_gr1)/60) ?> mins ago.</li>
                <li>Tribes: <?= $tribes[0]['COUNT(*)'] ?></li>
                <li>Players: <?= $characters[0]['COUNT(*)'] ?></li>
                <li>Villages: <?= $villages[0]['COUNT(*)'] ?></li>
            </ul>
        </li>
        <li>
            <strong>Cz - cz1 (Alnwick)</strong>
            <?php
                $tribes = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('tribe_cz1')
                    ->queryAll();
                $characters = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('character_cz1')
                    ->queryAll();
                $villages = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('village_cz1')
                    ->queryAll();
            ?>
            <ul>
                <li>Last update completed: <?= round((time()-$this->config->last_update_cz1)/60) ?> mins ago.</li>
                <li>Tribes: <?= $tribes[0]['COUNT(*)'] ?></li>
                <li>Players: <?= $characters[0]['COUNT(*)'] ?></li>
                <li>Villages: <?= $villages[0]['COUNT(*)'] ?></li>
            </ul>
        </li>
        <li>
            <strong>Pt - pt1 (Alnwick)</strong>
            <?php
                $tribes = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('tribe_pt1')
                    ->queryAll();
                $characters = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('character_pt1')
                    ->queryAll();
                $villages = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('village_pt1')
                    ->queryAll();
            ?>
            <ul>
                <li>Last update completed: <?= round((time()-$this->config->last_update_pt1)/60) ?> mins ago.</li>
                <li>Tribes: <?= $tribes[0]['COUNT(*)'] ?></li>
                <li>Players: <?= $characters[0]['COUNT(*)'] ?></li>
                <li>Villages: <?= $villages[0]['COUNT(*)'] ?></li>
            </ul>
        </li>
        <li>
            <strong>Se - se1 (Alnwick)</strong>
            <?php
                $tribes = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('tribe_se1')
                    ->queryAll();
                $characters = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('character_se1')
                    ->queryAll();
                $villages = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('village_se1')
                    ->queryAll();
            ?>
            <ul>
                <li>Last update completed: <?= round((time()-$this->config->last_update_se1)/60) ?> mins ago.</li>
                <li>Tribes: <?= $tribes[0]['COUNT(*)'] ?></li>
                <li>Players: <?= $characters[0]['COUNT(*)'] ?></li>
                <li>Villages: <?= $villages[0]['COUNT(*)'] ?></li>
            </ul>
        </li>
        
        <li>
            <strong>No - no1 (Alnwick)</strong>
            <?php
                $tribes = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('tribe_no1')
                    ->queryAll();
                $characters = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('character_no1')
                    ->queryAll();
                $villages = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('village_no1')
                    ->queryAll();
            ?>
            <ul>
                <li>Last update completed: <?= round((time()-$this->config->last_update_no1)/60) ?> mins ago.</li>
                <li>Tribes: <?= $tribes[0]['COUNT(*)'] ?></li>
                <li>Players: <?= $characters[0]['COUNT(*)'] ?></li>
                <li>Villages: <?= $villages[0]['COUNT(*)'] ?></li>
            </ul>
        </li>
        <li>
            <strong>Dk - dk1 (Alnwick)</strong>
            <?php
                $tribes = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('tribe_dk1')
                    ->queryAll();
                $characters = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('character_dk1')
                    ->queryAll();
                $villages = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('village_dk1')
                    ->queryAll();
            ?>
            <ul>
                <li>Last update completed: <?= round((time()-$this->config->last_update_dk1)/60) ?> mins ago.</li>
                <li>Tribes: <?= $tribes[0]['COUNT(*)'] ?></li>
                <li>Players: <?= $characters[0]['COUNT(*)'] ?></li>
                <li>Villages: <?= $villages[0]['COUNT(*)'] ?></li>
            </ul>
        </li>
        <li>
            <strong>Fi - fi1 (Alnwick)</strong>
            <?php
                $tribes = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('tribe_fi1')
                    ->queryAll();
                $characters = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('character_fi1')
                    ->queryAll();
                $villages = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('village_fi1')
                    ->queryAll();
            ?>
            <ul>
                <li>Last update completed: <?= round((time()-$this->config->last_update_fi1)/60) ?> mins ago.</li>
                <li>Tribes: <?= $tribes[0]['COUNT(*)'] ?></li>
                <li>Players: <?= $characters[0]['COUNT(*)'] ?></li>
                <li>Villages: <?= $villages[0]['COUNT(*)'] ?></li>
            </ul>
        </li>
        <li>
            <strong>Sk - sk1 (Alnwick)</strong>
            <?php
                $tribes = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('tribe_sk1')
                    ->queryAll();
                $characters = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('character_sk1')
                    ->queryAll();
                $villages = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('village_sk1')
                    ->queryAll();
            ?>
            <ul>
                <li>Last update completed: <?= round((time()-$this->config->last_update_sk1)/60) ?> mins ago.</li>
                <li>Tribes: <?= $tribes[0]['COUNT(*)'] ?></li>
                <li>Players: <?= $characters[0]['COUNT(*)'] ?></li>
                <li>Villages: <?= $villages[0]['COUNT(*)'] ?></li>
            </ul>
        </li>
        <li>
            <strong>Ro - ro1 (Alnwick)</strong>
            <?php
                $tribes = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('tribe_ro1')
                    ->queryAll();
                $characters = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('character_ro1')
                    ->queryAll();
                $villages = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('village_ro1')
                    ->queryAll();
            ?>
            <ul>
                <li>Last update completed: <?= round((time()-$this->config->last_update_ro1)/60) ?> mins ago.</li>
                <li>Tribes: <?= $tribes[0]['COUNT(*)'] ?></li>
                <li>Players: <?= $characters[0]['COUNT(*)'] ?></li>
                <li>Villages: <?= $villages[0]['COUNT(*)'] ?></li>
            </ul>
        </li>
        <li>
            <strong>Hu - hu1 (Alnwick)</strong>
            <?php
                $tribes = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('tribe_hu1')
                    ->queryAll();
                $characters = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('character_hu1')
                    ->queryAll();
                $villages = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('village_hu1')
                    ->queryAll();
            ?>
            <ul>
                <li>Last update completed: <?= round((time()-$this->config->last_update_hu1)/60) ?> mins ago.</li>
                <li>Tribes: <?= $tribes[0]['COUNT(*)'] ?></li>
                <li>Players: <?= $characters[0]['COUNT(*)'] ?></li>
                <li>Villages: <?= $villages[0]['COUNT(*)'] ?></li>
            </ul>
        </li>
        <li>
            <strong>Ar - ar1 (Alnwick)</strong>
            <?php
                $tribes = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('tribe_ar1')
                    ->queryAll();
                $characters = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('character_ar1')
                    ->queryAll();
                $villages = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('village_ar1')
                    ->queryAll();
            ?>
            <ul>
                <li>Last update completed: <?= round((time()-$this->config->last_update_ar1)/60) ?> mins ago.</li>
                <li>Tribes: <?= $tribes[0]['COUNT(*)'] ?></li>
                <li>Players: <?= $characters[0]['COUNT(*)'] ?></li>
                <li>Villages: <?= $villages[0]['COUNT(*)'] ?></li>
            </ul>
        </li>
        
    </ul>

<?php $this->endWidget(); ?>