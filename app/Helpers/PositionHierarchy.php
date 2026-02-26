<?php

namespace App\Helpers;

class PositionHierarchy
{
    /**
     * Full hierarchy: level_key => ordered positions (index 0 = highest rank)
     */
    public static array $levels = [
        'rashtriya' => [
            "राष्ट्रीय अध्यक्ष", "राष्ट्रीय उपाध्यक्ष 1", "राष्ट्रीय उपाध्यक्ष 2",
            "राष्ट्रीय उपाध्यक्ष 3", "राष्ट्रीय उपाध्यक्ष 4", "राष्ट्रीय महासचिव",
            "राष्ट्रीय सचिव", "राष्ट्रीय कोषाध्यक्ष", "राष्ट्रीय संगठन मंत्री",
            "जिला प्रभारी", "राष्ट्रीय सदस्य"
        ],
        'pradesh' => [
            "प्रदेश अध्यक्ष", "प्रदेश उपाध्यक्ष 1", "प्रदेश उपाध्यक्ष 2",
            "प्रदेश उपाध्यक्ष 3", "प्रदेश उपाध्यक्ष 4", "प्रदेश महासचिव",
            "प्रदेश सचिव", "प्रदेश कोषाध्यक्ष", "प्रदेश संगठन मंत्री",
            "प्रदेश प्रभारी", "प्रदेश सदस्य"
        ],
        'mandal' => [
            "मंडल अध्यक्ष", "मंडल उपाध्यक्ष 1", "मंडल उपाध्यक्ष 2",
            "मंडल उपाध्यक्ष 3", "मंडल उपाध्यक्ष 4", "मंडल महासचिव",
            "जिला सचिव", "मंडल कोषाध्यक्ष", "मंडल संगठन मंत्री",
            "मंडल प्रभारी", "मंडल सदस्य"
        ],
        'jila' => [
            "जिला अध्यक्ष", "जिला उपाध्यक्ष 1", "जिला उपाध्यक्ष 2",
            "जिला उपाध्यक्ष 3", "जिला उपाध्यक्ष 4", "जिला महासचिव",
            "जिला सचिव", "जिला कोषाध्यक्ष", "जिला संगठन मंत्री",
            "जिला प्रभारी", "जिला सदस्य"
        ],
        'nagar' => [
            "नगर अध्यक्ष", "नगर प्रभारी", "मोहल्ला प्रभारी",
            "मोहल्ला संचालक", "तहसील प्रभारी"
        ],
        'block' => [
            "ब्लॉक अध्यक्ष", "ब्लॉक उपाध्यक्ष", "ब्लॉक कोषाध्यक्ष",
            "ब्लॉक सचिव", "ब्लॉक संगठन मंत्री", "ब्लॉक सदस्य"
        ],
        'gram' => [
            "ग्राम प्रभारी", "ग्राम अध्यक्ष", "ग्राम सचिव",
            "ग्राम कोषाध्यक्ष", "ग्राम सदस्य"
        ],
    ];

    /**
     * Level order: rashtriya=0 (highest) ... gram=6 (lowest)
     */
    public static array $levelOrder = [
        'rashtriya' => 0,
        'pradesh'   => 1,
        'mandal'    => 2,
        'jila'      => 3,
        'nagar'     => 4,
        'block'     => 5,
        'gram'      => 6,
    ];

    /**
     * Get level key for a given position name
     */
    public static function getLevelByPosition(string $position): ?string
    {
        foreach (self::$levels as $level => $positions) {
            if (in_array($position, $positions)) {
                return $level;
            }
        }
        return null;
    }

    /**
     * Get numeric order of a level key (lower = higher rank)
     */
    public static function getLevelOrder(string $levelKey): int
    {
        return self::$levelOrder[$levelKey] ?? 999;
    }

    /**
     * Get numeric order of a position
     */
    public static function getPositionOrder(string $position): int
    {
        $level = self::getLevelByPosition($position);
        return $level ? self::getLevelOrder($level) : 999;
    }

    /**
     * Check if positionA is HIGHER (senior) than positionB
     */
    public static function isHigher(string $positionA, string $positionB): bool
    {
        return self::getPositionOrder($positionA) < self::getPositionOrder($positionB);
    }

    /**
     * Is this the lowest level (gram)?
     */
    public static function isLowestLevel(string $position): bool
    {
        return self::getLevelByPosition($position) === 'gram';
    }

    /**
     * Can a member with this position add sub-members?
     * Rule: NOT gram level
     */
    public static function canAddSubMembers(string $position): bool
    {
        return !self::isLowestLevel($position);
    }

    /**
     * Get all levels BELOW a given level key (levels that can be assigned as sub-members)
     */
    public static function getLevelsBelow(string $levelKey): array
    {
        $currentOrder = self::getLevelOrder($levelKey);
        $below = [];
        foreach (self::$levelOrder as $key => $order) {
            if ($order > $currentOrder) {
                $below[$key] = self::$levels[$key];
            }
        }
        return $below;
    }

    /**
     * Get all positions available for sub-member assignment
     * (only levels strictly below the parent's level)
     */
    public static function getAllowedSubPositions(string $parentPosition): array
    {
        $parentLevel = self::getLevelByPosition($parentPosition);
        if (!$parentLevel) return [];
        return self::getLevelsBelow($parentLevel);
    }

    /**
     * Get level label in Hindi/English
     */
    public static function getLevelLabel(string $levelKey): string
    {
        return match($levelKey) {
            'rashtriya' => 'राष्ट्रीय (National)',
            'pradesh'   => 'प्रदेश (State)',
            'mandal'    => 'मंडल (Division)',
            'jila'      => 'जिला (District)',
            'nagar'     => 'नगर (City)',
            'block'     => 'ब्लॉक (Block)',
            'gram'      => 'ग्राम (Village)',
            default     => ucfirst($levelKey),
        };
    }

    /**
     * Get badge color for level
     */
    public static function getLevelColor(string $levelKey): string
    {
        return match($levelKey) {
            'rashtriya' => 'danger',
            'pradesh'   => 'warning',
            'mandal'    => 'info',
            'jila'      => 'primary',
            'nagar'     => 'success',
            'block'     => 'secondary',
            'gram'      => 'dark',
            default     => 'secondary',
        };
    }

    /**
     * Full flat list of all positions
     */
    public static function getAllPositions(): array
    {
        return array_merge(...array_values(self::$levels));
    }
}