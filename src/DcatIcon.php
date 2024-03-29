<?php
declare(strict_types=1);

namespace Dcat\Admin;

enum DcatIcon: string {
	public const PREFIX = 'fa-';
	public const BASE   = 'fas ';

	case CALENDAR = 'calendar';
	case HOME = 'home';
	case HELP = 'question-circle';
	case PROFILE = 'user-edit';
    case SETTINGS = 'cog';
	case LOGOUT = 'power-off';
	case GLOBE = 'globe';
	case DOTS_VERTICAL_ROUNDED = 'ellipsis-v';
	case MENU = 'menu';
	case EMAIL = 'envelope';
	case HIDE = 'eye-slash';
	case PENCIL = 'pencil';
	case MOBILE = 'mobile';
	case INTERNET = 'edit';
	case LAPTOP = 'laptop';
	case TERMINAL = 'terminal';
	case USER = 'user';
	case MESSAGE_SQUARE = 'message-square';
    case TRASH = 'trash';
    case EYE = 'eye';
    case DOLLAR_SIGN = 'dollar-sign';
    case CHART_LINE_DOWN = 'chart-line-down';
    case ARROW_TREND_DOWN = 'arrow-trend-down';
    case ARROW_TREND_UP = 'arrow-trend-up';
    case START = 'hourglass-start ';
    case END = 'stop';
    case DESKTOP = 'desktop';
    case BROKER = 'user-secret';
    case LOCK = 'lock';
    case SHIELD = 'shield';
    case MEDAL = 'medal';
    case CONTACT_US = 'phone-alt';
    case SHARE_ALT = 'share-alt';
    case HAND_DOWN = 'hand-o-down';
    case RECYCLE = 'recycle';
    case MAP = 'map-pin';
    case CHART_COLUMN = 'chart-column';

	public function _(bool $fullTag = FALSE, ?string $title = null) {
		return self::format($this, $fullTag, $title);
	}

	public static function __callStatic($name, $args) {
		$fullTag = FALSE;
        $title = null;

		if ( $args && count($args) > 0 ) {
			$fullTag = $args[0];
            $title = isset($args[1]) ? $args[1] : '';
		}
		$cases = static::cases();
		foreach ($cases as $case) {
			if ( $case->name === $name ) {
				return $case->_($fullTag, $title);
			}
		}
	}

	public static function format(DcatIcon $icon, bool $fullTag = FALSE, ?string $title = null)
	: string {
		$class = self::BASE . self::PREFIX . $icon->value;
        $title = !is_null($title) ? 'title="'.$title.'"' : '';

		if ( $fullTag ) {
			return '<i class="'.$class.'" $title></i>';
		}
		return $class;
	}

    public static function base( string $icon) {
        return self::BASE.$icon;
    }
}
