<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201121161426 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE admin (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', image_name VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, image_path VARCHAR(255) DEFAULT NULL, last_name VARCHAR(150) NOT NULL, first_name VARCHAR(150) NOT NULL, birth_date DATE DEFAULT NULL, birth_place VARCHAR(150) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, gender VARCHAR(70) DEFAULT NULL, phone VARCHAR(35) DEFAULT NULL, last_activity DATETIME DEFAULT NULL, first_login_today DATETIME DEFAULT NULL, discr VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_8D93D649C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calendar (id INT AUTO_INCREMENT NOT NULL, service_id INT DEFAULT NULL, bg_color VARCHAR(255) DEFAULT NULL, type VARCHAR(55) DEFAULT NULL, UNIQUE INDEX UNIQ_6EA9A146ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctor (id INT NOT NULL, specialisation_id INT DEFAULT NULL, num_prof INT DEFAULT NULL, title VARCHAR(195) DEFAULT NULL, company VARCHAR(195) DEFAULT NULL, person_opening_account VARCHAR(195) DEFAULT NULL, date_opened DATE NOT NULL, workingtime VARCHAR(10) DEFAULT NULL, INDEX IDX_1FC0F36A5627D44C (specialisation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, start_datetime DATETIME NOT NULL, end_datetime DATETIME DEFAULT NULL, bg_color VARCHAR(255) DEFAULT NULL, fg_color VARCHAR(255) DEFAULT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hospital_center (id INT AUTO_INCREMENT NOT NULL, doctor_id INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, wilaya VARCHAR(255) DEFAULT NULL, town VARCHAR(255) DEFAULT NULL, fax VARCHAR(255) DEFAULT NULL, web_site VARCHAR(255) DEFAULT NULL, update_date DATE DEFAULT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_9F915E7787F4FB17 (doctor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medical_personal_history (id INT AUTO_INCREMENT NOT NULL, allergies LONGTEXT DEFAULT NULL, medical_histories LONGTEXT DEFAULT NULL, surgical_histories LONGTEXT DEFAULT NULL, traumatic_histories LONGTEXT DEFAULT NULL, obstetrical_histories LONGTEXT DEFAULT NULL, psychomotor_development LONGTEXT DEFAULT NULL, familysurgical LONGTEXT DEFAULT NULL, familymedical LONGTEXT DEFAULT NULL, psychiatric LONGTEXT DEFAULT NULL, toxic LONGTEXT DEFAULT NULL, prison LONGTEXT DEFAULT NULL, trauma LONGTEXT DEFAULT NULL, summary LONGTEXT DEFAULT NULL, menarche LONGTEXT DEFAULT NULL, menopause LONGTEXT DEFAULT NULL, parity LONGTEXT DEFAULT NULL, gravidity LONGTEXT DEFAULT NULL, cycle LONGTEXT DEFAULT NULL, dysmenorrhea LONGTEXT DEFAULT NULL, dyspareunia LONGTEXT DEFAULT NULL, abundance LONGTEXT DEFAULT NULL, menstruation_duration LONGTEXT DEFAULT NULL, other LONGTEXT DEFAULT NULL, initial_weight LONGTEXT DEFAULT NULL, cesarean LONGTEXT DEFAULT NULL, abortion LONGTEXT DEFAULT NULL, contraception_type LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT NOT NULL, medical_personal_history_id INT DEFAULT NULL, husbands_name VARCHAR(150) DEFAULT NULL, fax VARCHAR(55) DEFAULT NULL, num_cartechifae VARCHAR(20) DEFAULT NULL, family_status VARCHAR(25) DEFAULT NULL, emergency_phone VARCHAR(55) DEFAULT NULL, traiting_doctor VARCHAR(255) DEFAULT NULL, blood_group VARCHAR(25) DEFAULT NULL, profession VARCHAR(50) DEFAULT NULL, origin VARCHAR(255) DEFAULT NULL, referenced_by VARCHAR(155) DEFAULT NULL, UNIQUE INDEX UNIQ_1ADAD7EB690821EB (medical_personal_history_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patientevent (id INT NOT NULL, patient_id INT NOT NULL, doctor_id INT NOT NULL, motif_id INT NOT NULL, type_rdv VARCHAR(20) NOT NULL, updatedate DATETIME NOT NULL, number_of_change_doctor TINYINT(1) NOT NULL, number_of_change_patient TINYINT(1) NOT NULL, INDEX IDX_EF1A37746B899279 (patient_id), INDEX IDX_EF1A377487F4FB17 (doctor_id), INDEX IDX_EF1A3774D0EEB819 (motif_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pattern_type (id INT AUTO_INCREMENT NOT NULL, doctor_id INT NOT NULL, motif LONGTEXT NOT NULL, INDEX IDX_5AF3688087F4FB17 (doctor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE remindingevent (id INT NOT NULL, doctor_id INT NOT NULL, patient_id INT DEFAULT NULL, body LONGTEXT DEFAULT NULL, state VARCHAR(100) NOT NULL, INDEX IDX_66F3082287F4FB17 (doctor_id), INDEX IDX_66F308226B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, admin_created_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, update_date DATE DEFAULT NULL, responsible VARCHAR(195) DEFAULT NULL, INDEX IDX_E19D9AD296DEB8C1 (admin_created_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE treating_doctor (id INT AUTO_INCREMENT NOT NULL, doctor_id INT DEFAULT NULL, patient_id INT DEFAULT NULL, INDEX IDX_A6C0B42287F4FB17 (doctor_id), INDEX IDX_A6C0B4226B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_event (id INT NOT NULL, doctor_id INT NOT NULL, INDEX IDX_D96CF1FF87F4FB17 (doctor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wilaya (id INT AUTO_INCREMENT NOT NULL, code_postal INT NOT NULL, ville VARCHAR(255) NOT NULL, wilaya VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A146ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE doctor ADD CONSTRAINT FK_1FC0F36A5627D44C FOREIGN KEY (specialisation_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE doctor ADD CONSTRAINT FK_1FC0F36ABF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hospital_center ADD CONSTRAINT FK_9F915E7787F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB690821EB FOREIGN KEY (medical_personal_history_id) REFERENCES medical_personal_history (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EBBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE patientevent ADD CONSTRAINT FK_EF1A37746B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE patientevent ADD CONSTRAINT FK_EF1A377487F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id)');
        $this->addSql('ALTER TABLE patientevent ADD CONSTRAINT FK_EF1A3774D0EEB819 FOREIGN KEY (motif_id) REFERENCES pattern_type (id)');
        $this->addSql('ALTER TABLE patientevent ADD CONSTRAINT FK_EF1A3774BF396750 FOREIGN KEY (id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pattern_type ADD CONSTRAINT FK_5AF3688087F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id)');
        $this->addSql('ALTER TABLE remindingevent ADD CONSTRAINT FK_66F3082287F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id)');
        $this->addSql('ALTER TABLE remindingevent ADD CONSTRAINT FK_66F308226B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE remindingevent ADD CONSTRAINT FK_66F30822BF396750 FOREIGN KEY (id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD296DEB8C1 FOREIGN KEY (admin_created_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE treating_doctor ADD CONSTRAINT FK_A6C0B42287F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id)');
        $this->addSql('ALTER TABLE treating_doctor ADD CONSTRAINT FK_A6C0B4226B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE user_event ADD CONSTRAINT FK_D96CF1FF87F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id)');
        $this->addSql('ALTER TABLE user_event ADD CONSTRAINT FK_D96CF1FFBF396750 FOREIGN KEY (id) REFERENCES evenement (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD296DEB8C1');
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D76BF396750');
        $this->addSql('ALTER TABLE doctor DROP FOREIGN KEY FK_1FC0F36ABF396750');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EBBF396750');
        $this->addSql('ALTER TABLE hospital_center DROP FOREIGN KEY FK_9F915E7787F4FB17');
        $this->addSql('ALTER TABLE patientevent DROP FOREIGN KEY FK_EF1A377487F4FB17');
        $this->addSql('ALTER TABLE pattern_type DROP FOREIGN KEY FK_5AF3688087F4FB17');
        $this->addSql('ALTER TABLE remindingevent DROP FOREIGN KEY FK_66F3082287F4FB17');
        $this->addSql('ALTER TABLE treating_doctor DROP FOREIGN KEY FK_A6C0B42287F4FB17');
        $this->addSql('ALTER TABLE user_event DROP FOREIGN KEY FK_D96CF1FF87F4FB17');
        $this->addSql('ALTER TABLE patientevent DROP FOREIGN KEY FK_EF1A3774BF396750');
        $this->addSql('ALTER TABLE remindingevent DROP FOREIGN KEY FK_66F30822BF396750');
        $this->addSql('ALTER TABLE user_event DROP FOREIGN KEY FK_D96CF1FFBF396750');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB690821EB');
        $this->addSql('ALTER TABLE patientevent DROP FOREIGN KEY FK_EF1A37746B899279');
        $this->addSql('ALTER TABLE remindingevent DROP FOREIGN KEY FK_66F308226B899279');
        $this->addSql('ALTER TABLE treating_doctor DROP FOREIGN KEY FK_A6C0B4226B899279');
        $this->addSql('ALTER TABLE patientevent DROP FOREIGN KEY FK_EF1A3774D0EEB819');
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A146ED5CA9E6');
        $this->addSql('ALTER TABLE doctor DROP FOREIGN KEY FK_1FC0F36A5627D44C');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE calendar');
        $this->addSql('DROP TABLE doctor');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE hospital_center');
        $this->addSql('DROP TABLE medical_personal_history');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE patientevent');
        $this->addSql('DROP TABLE pattern_type');
        $this->addSql('DROP TABLE remindingevent');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE treating_doctor');
        $this->addSql('DROP TABLE user_event');
        $this->addSql('DROP TABLE wilaya');
    }
}
