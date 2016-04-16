<?php
/**
 * @package jpWot
 * @author Philipp John <info@jplace.de>
 * @copyright (c) 2014, Philipp John
 * @license http://opensource.org/licenses/MIT MIT see LICENSE.md
 */
namespace AppBundle\Wot;

abstract class WotConfig
{
	/**
	 * @var string
	 */
	public static $region = 'EU';

	/**
	 * @var string
	 */
	public static $lang = 'en';

	/**
	 * @var string
	 */
	public static $app_id = [ 	0 => 'bf50bd80740ecfaa1c587f5efc3772b9',
								1 => '2ccca06d783770bbd7b7c35670d3f5b9',
								2 => 'f523731f069c8df938ef6d01c66efddd'];

	public static $refresh_interval = 600; //secs

	/**
	 * @var string
	 */
	public static $cache = null;

	/**
	 * @var array
	 */
	public static $cacheParams = array (
		'host' => null,
		'port' => null
	);

	public static $wotApiFields = array (
        'events' => array(
            'search' => array(
                'end',
                'event_id',
                'event_name',
                'start',
                'status',
                'fronts.front_id',
            ),
            'accountinfo' => array(
                'events.award_level',
                'events.battles',
                'events.battles_to_award',
                'events.fame_points',
                'events.fame_points_to_improve_award',
                'events.rank',
                'events.clan_id',
            ),
        ),
		'accounts' => array (
			'search' => array (
				'account_id',
				'nickname',
			),
			'detail' => array (
				'account_id',
				'clan_id',
				'created_at',
				'global_rating',
				'last_battle_time',
				'nickname',
				'updated_at',
				'statistics.frags',
				'statistics.trees_cut',
				'client_language',
				'statistics.all',
			),
		),
		'clans' => array (
			'search' => array (
				'clan_id',
				'color',
				'created_at',
				'members_count',
				'name',
				'tag',
			),
			'detail' => array (
				'tag',
				'clan_id',
				'color',
				'created_at',
				'description',
				'description_html',
				'is_clan_disbanded',
				'members_count',
				'motto',
				'name',
				'creator_id',
				'creator_name',
				'updated_at',
				'members',
			),
		),
		'wiki' => array (
			'tankinfo' => array (
				'name',
				'name_i18n',
				'nation',
				'nation_i18n',
				'tank_id',
				'type',
				'type_i18n',
				'contour_image',
				'image',
				'image_small',
				'level',
				'short_name_i18n',
			)
		),
	);

	/**
	 * @var bool
	 */
	public static $debug = false;
}
