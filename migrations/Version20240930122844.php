<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240930122844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A3256915B');
        $this->addSql('DROP INDEX IDX_E01FBE6A3256915B ON images');
        $this->addSql('ALTER TABLE images CHANGE relation_id produit_laitier_id INT NOT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A3BEDBD50 FOREIGN KEY (produit_laitier_id) REFERENCES produit_laitier (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A3BEDBD50 ON images (produit_laitier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A3BEDBD50');
        $this->addSql('DROP INDEX IDX_E01FBE6A3BEDBD50 ON images');
        $this->addSql('ALTER TABLE images CHANGE produit_laitier_id relation_id INT NOT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A3256915B FOREIGN KEY (relation_id) REFERENCES produit_laitier (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A3256915B ON images (relation_id)');
    }
}
