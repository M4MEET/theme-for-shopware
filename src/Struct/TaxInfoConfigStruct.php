<?php declare(strict_types=1);

namespace ThemeBattronGmbh\Struct;

use Shopware\Core\Framework\Struct\Struct;

/**
 * Class TaxInfoConfigStruct
 *
 * This class extends the Shopware's Struct class and is used to hold the configuration for tax information.
 * It has a single property, $taxEntity, which represents the tax entity ID selected in the plugin configuration.
 */
class TaxInfoConfigStruct extends Struct
{
    /**
     * @var ?string The tax entity ID selected in the plugin configuration.
     */
    protected ?string $taxEntity;

    /**
     * TaxInfoConfigStruct constructor.
     *
     * @param ?string $taxEntity The tax entity ID selected in the plugin configuration.
     */
    public function __construct(?string $taxEntity)
    {
        $this->taxEntity = $taxEntity;
    }

    /**
     * Gets the tax entity ID.
     *
     * @return ?string The tax entity ID.
     */
    public function getTaxEntity(): ?string
    {
        return $this->taxEntity;
    }

    /**
     * Sets the tax entity ID.
     *
     * @param ?string $taxEntity The tax entity ID.
     */
    public function setTaxEntity(?string $taxEntity): void
    {
        $this->taxEntity = $taxEntity;
    }
}