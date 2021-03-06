<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

namespace TechDivision\PspMock\Entity\Heidelpay;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use TechDivision\PspMock\Entity\Account;
use TechDivision\PspMock\Entity\Address;
use TechDivision\PspMock\Entity\Customer;
use TechDivision\PspMock\Entity\Interfaces\PspOrderInterface;

/**
 * @ORM\Entity(repositoryClass="TechDivision\PspMock\Repository\Heidelpay\OrderRepository")
 * @ORM\Table(name="heidelpay_order")
 *
 * @copyright  Copyright (c) 2018 TechDivision GmbH (https://www.techdivision.com)
 * @link       https://www.techdivision.com/
 * @author     Lukas Kiederle <l.kiederle@techdivision.com
 */
class Order implements PspOrderInterface
{
    /**
     * Status
     */
    const STATUS_NEW = 'NEW';

    /**
     * StateId length
     */
    const STATE_ID_LENGTH = 24;

    /**
     * Prefixes
     */
    const IDENTIFICATION = 'IDENTIFICATION_';
    const ADDRESS = 'ADDRESS_';
    const CONFIG = 'CONFIG_';
    const ACCOUNT = 'ACCOUNT_';
    const NAME = 'NAME_';
    const CRITERION = 'CRITERION_';
    const PRESENTATION = 'PRESENTATION_';
    const CURRENCY = 'CURRENCY_';
    const TRANSACTION = 'TRANSACTION_';
    const CONTACT = 'CONTACT_';
    const FRONTEND = 'FRONTEND_';
    const REQUEST = 'REQUEST_';
    const SECURITY = 'SECURITY_';
    const PROCESSING = 'PROCESSING_';
    const PAYMENT = 'PAYMENT_';
    const USER = 'USER_';
    const POST_ = 'POST_';


    /**
     * IDENTIFICATION_
     */

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\SequenceGenerator(sequenceName="id", initialValue=250000)
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $transactionId;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $ShortId;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $uniqueId;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $store;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true, unique=true)
     */
    private $stateId;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $referenceId;

    /**
     * ADDRESS_
     */

    /**
     * @var address
     *
     * One Order has One Address.
     * @ORM\ManyToOne(targetEntity="TechDivision\PspMock\Entity\Address", cascade={"persist"})
     */
    private $address;

    /**
     * ACCOUNT_
     */

    /**
     * @var account
     *
     * One Order has One Account.
     * @ORM\ManyToOne(targetEntity="TechDivision\PspMock\Entity\Account", cascade={"persist"})
     */
    private $account;

    /**
     * NAME_
     */

    /**
     * @var Customer
     *
     * One Order has One Account.
     * @ORM\ManyToOne(targetEntity="TechDivision\PspMock\Entity\Customer", cascade={"persist"})
     */
    private $customer;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $company;

    /**
     * CONFIG_
     */

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $brands = "{\"MASTER\":\"MasterCard\",\"AMEX\":\"American Express\",\"JCB\":\"JCB\",\"DISCOVERY\":\"Discover\",\"DINERS\":\"Diners\",\"CUP\":\"China Union Pay\",\"VISA\":\"Visa\"}";

    /**
     * CRITERION_
     */

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $sdkName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $sdkVersion;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $pushUrl;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $shopType = 'Magento 2.1.16-Community';

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $paymentMethod = 'CreditCardPaymentMethod';

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $shopmoduleVerison = 'Heidelpay Gateway 18.6.11';

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $secret;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $guest = 'true';

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $requestData;

    /**
     * PRESENTATION_
     */

    /**
     * @var string
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $pAmount;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $pCurrency;

    /**
     * CLEARING_
     */

    /**
     * @var string
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $cAmount;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $cCurrency;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $descriptor;

    /**
     * TRANSACTION_
     */

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $mode;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $channel;

    /**
     * CONTACT_
     */

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $email;

    /**
     * FRONTEND_
     */

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $enabled;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $responseUrl;


    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $paymentFrameOrigin;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $cssPath = 'http:\/\/demoshops.heidelpay.de\/css\/mage2-hpf.css';

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $fMode = 'WHITELABEL';

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $preventAsyncRedirect = 'FALSE';

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $language = 'EN';

    /**
     * REQUEST_
     */

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $version = '1.0';

    /**
     * PROCESSING_
     */

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $statusCode = "90";

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $processingCode;

    /**
     * @var string
     *
     * @ORM\Column(type="string", options={"default":"NEW"})
     * @Assert\NotBlank
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(options={"default":0})
     * @Assert\NotBlank
     */
    private $timestamp;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $returnCode;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $result = "ACK";

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $reasonCode = "00";

    /**
     * @var string
     *
     * @ORM\Column(type="string", options={"default":"SUCCESSFULL"}, nullable=true)
     */
    private $reason;

    /**
     * @var string
     *
     * @ORM\Column(type="string", options={"default":"Request successfully processed in ''Merchant in Connector Test Mode''"}, nullable=true)
     */
    private $return;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $redirectUrl;

    /**
     * SECURITY_
     */

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $sender;

    /**
     * USER_
     */

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $login = '31ha07bc8142c5a171744e5aef11ffd3';

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $pwd = '93167DE7';

    /**
     * PAYMENT_
     */

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $code;

    /**
     * POST_
     */

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $validation = "ACK";

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $paymentFrameUrl;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $initialRequestData;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    /**
     * @return string
     */
    public function getLastName()
    {
        return ($this->customer != null) ? $this->customer->getLastName() : 'n/a';
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return ($this->customer) ? $this->customer->getFirstName() : 'n/a';
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     */
    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created): void
    {
        $this->created = $created;
    }

    /**
     * @return string
     */
    public function getPaymentFrameUrl(): string
    {
        return $this->paymentFrameUrl;
    }

    /**
     * @param string $paymentFrameUrl
     */
    public function setPaymentFrameUrl(string $paymentFrameUrl): void
    {
        $this->paymentFrameUrl = $paymentFrameUrl;
    }

    /**
     * @return string
     */
    public function getValidation(): string
    {
        return $this->validation;
    }

    /**
     * @param string $validation
     */
    public function setValidation(string $validation): void
    {
        $this->validation = $validation;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    /**
     * @param string $transactionId
     */
    public function setTransactionId(string $transactionId): void
    {
        $this->transactionId = $transactionId;
    }

    /**
     * @return string
     */
    public function getShortId(): string
    {
        return $this->ShortId;
    }

    /**
     * @param string $ShortId
     */
    public function setShortId(string $ShortId): void
    {
        $this->ShortId = $ShortId;
    }

    /**
     * @return string
     */
    public function getUniqueId(): string
    {
        return $this->uniqueId;
    }

    /**
     * @param string $uniqueId
     */
    public function setUniqueId(string $uniqueId): void
    {
        $this->uniqueId = $uniqueId;
    }

    /**
     * @return string
     */
    public function getStore(): string
    {
        return $this->store;
    }

    /**
     * @param string $store
     */
    public function setStore(string $store): void
    {
        $this->store = $store;
    }

    /**
     * @return address
     */
    public function getAddress(): address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function setAddress(address $address): void
    {
        $this->address = $address;
    }

    /**
     * @return account
     */
    public function getAccount(): account
    {
        return $this->account;
    }

    /**
     * @param Account $account
     */
    public function setAccount(account $account): void
    {
        $this->account = $account;
    }

    /**
     * @return string
     */
    public function getCompany(): string
    {
        return $this->company;
    }

    /**
     * @param string $company
     */
    public function setCompany(string $company): void
    {
        $this->company = $company;
    }

    /**
     * @return string
     */
    public function getBrands(): string
    {
        return $this->brands;
    }

    /**
     * @param string $brands
     */
    public function setBrands(string $brands): void
    {
        $this->brands = $brands;
    }

    /**
     * @return string
     */
    public function getSdkName(): string
    {
        return $this->sdkName;
    }

    /**
     * @param string $sdkName
     */
    public function setSdkName(string $sdkName): void
    {
        $this->sdkName = $sdkName;
    }

    /**
     * @return string
     */
    public function getSdkVersion(): string
    {
        return $this->sdkVersion;
    }

    /**
     * @param string $sdkVersion
     */
    public function setSdkVersion(string $sdkVersion): void
    {
        $this->sdkVersion = $sdkVersion;
    }

    /**
     * @return string
     */
    public function getPushUrl(): string
    {
        return $this->pushUrl;
    }

    /**
     * @param string $pushUrl
     */
    public function setPushUrl(string $pushUrl): void
    {
        $this->pushUrl = $pushUrl;
    }

    /**
     * @return string
     */
    public function getShopType(): string
    {
        return $this->shopType;
    }

    /**
     * @param string $shopType
     */
    public function setShopType(string $shopType): void
    {
        $this->shopType = $shopType;
    }

    /**
     * @return string
     */
    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }

    /**
     * @param string $paymentMethod
     */
    public function setPaymentMethod(string $paymentMethod): void
    {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * @return string
     */
    public function getShopmoduleVerison(): string
    {
        return $this->shopmoduleVerison;
    }

    /**
     * @param string $shopmoduleVerison
     */
    public function setShopmoduleVerison(string $shopmoduleVerison): void
    {
        $this->shopmoduleVerison = $shopmoduleVerison;
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }

    /**
     * @param string $secret
     */
    public function setSecret(string $secret): void
    {
        $this->secret = $secret;
    }

    /**
     * @return string
     */
    public function getGuest(): string
    {
        return $this->guest;
    }

    /**
     * @param string $guest
     */
    public function setGuest(string $guest): void
    {
        $this->guest = $guest;
    }

    /**
     * @return string
     */
    public function getRequestData(): string
    {
        return $this->requestData;
    }

    /**
     * @param string $requestData
     */
    public function setRequestData(string $requestData): void
    {
        $this->requestData = $requestData;
    }

    /**
     * @return string
     */
    public function getPAmount(): string
    {
        return $this->pAmount;
    }

    /**
     * @param string $pAmount
     */
    public function setPAmount(string $pAmount): void
    {
        $this->pAmount = $pAmount;
    }

    /**
     * @return string
     */
    public function getPCurrency(): string
    {
        return $this->pCurrency;
    }

    /**
     * @param string $pCurrency
     */
    public function setPCurrency(string $pCurrency): void
    {
        $this->pCurrency = $pCurrency;
    }

    /**
     * @return string
     */
    public function getCAmount(): string
    {
        return ($this->cAmount === null) ? 'n/a' : $this->cAmount;
    }

    /**
     * @param string $cAmount
     */
    public function setCAmount(string $cAmount): void
    {
        $this->cAmount = $cAmount;
    }

    /**
     * @return string
     */
    public function getCCurrency(): string
    {
        return $this->cCurrency;
    }

    /**
     * @param string $cCurrency
     */
    public function setCCurrency(string $cCurrency): void
    {
        $this->cCurrency = $cCurrency;
    }

    /**
     * @return string
     */
    public function getDescriptor(): string
    {
        return $this->descriptor;
    }

    /**
     * @param string $descriptor
     */
    public function setDescriptor(string $descriptor): void
    {
        $this->descriptor = $descriptor;
    }

    /**
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * @param string $mode
     */
    public function setMode(string $mode): void
    {
        $this->mode = $mode;
    }

    /**
     * @return string
     */
    public function getChannel(): string
    {
        return $this->channel;
    }

    /**
     * @param string $channel
     */
    public function setChannel(string $channel): void
    {
        $this->channel = $channel;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp(string $ip): void
    {
        $this->ip = $ip;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEnabled(): string
    {
        return $this->enabled;
    }

    /**
     * @param string $enabled
     */
    public function setEnabled(string $enabled): void
    {
        $this->enabled = $enabled;
    }

    /**
     * @return string
     */
    public function getResponseUrl(): string
    {
        return $this->responseUrl;
    }

    /**
     * @param string $responseUrl
     */
    public function setResponseUrl(string $responseUrl): void
    {
        $this->responseUrl = $responseUrl;
    }

    /**
     * @return string
     */
    public function getPaymentFrameOrigin(): string
    {
        return $this->paymentFrameOrigin;
    }

    /**
     * @param string $paymentFrameOrigin
     */
    public function setPaymentFrameOrigin(string $paymentFrameOrigin): void
    {
        $this->paymentFrameOrigin = $paymentFrameOrigin;
    }

    /**
     * @return string
     */
    public function getCssPath(): string
    {
        return $this->cssPath;
    }

    /**
     * @param string $cssPath
     */
    public function setCssPath(string $cssPath): void
    {
        $this->cssPath = $cssPath;
    }

    /**
     * @return string
     */
    public function getFMode(): string
    {
        return $this->fMode;
    }

    /**
     * @param string $fMode
     */
    public function setFMode(string $fMode): void
    {
        $this->fMode = $fMode;
    }

    /**
     * @return string
     */
    public function getPreventAsyncRedirect(): string
    {
        return $this->preventAsyncRedirect;
    }

    /**
     * @param string $preventAsyncRedirect
     */
    public function setPreventAsyncRedirect(string $preventAsyncRedirect): void
    {
        $this->preventAsyncRedirect = $preventAsyncRedirect;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getStatusCode(): string
    {
        return $this->statusCode;
    }

    /**
     * @param string $statusCode
     */
    public function setStatusCode(string $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return string
     */
    public function getProcessingCode(): string
    {
        return $this->processingCode;
    }

    /**
     * @param string $processingCode
     */
    public function setProcessingCode(string $processingCode): void
    {
        $this->processingCode = $processingCode;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @param int $timestamp
     */
    public function setTimestamp(int $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return string
     */
    public function getReturnCode(): string
    {
        return $this->returnCode;
    }

    /**
     * @param string $returnCode
     */
    public function setReturnCode(string $returnCode): void
    {
        $this->returnCode = $returnCode;
    }

    /**
     * @return string
     */
    public function getResult(): string
    {
        return $this->result;
    }

    /**
     * @param string $result
     */
    public function setResult(string $result): void
    {
        $this->result = $result;
    }

    /**
     * @return string
     */
    public function getReasonCode(): string
    {
        return $this->reasonCode;
    }

    /**
     * @param string $reasonCode
     */
    public function setReasonCode(string $reasonCode): void
    {
        $this->reasonCode = $reasonCode;
    }

    /**
     * @return string
     */
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     */
    public function setReason(string $reason): void
    {
        $this->reason = $reason;
    }

    /**
     * @return string
     */
    public function getReturn(): string
    {
        return $this->return;
    }

    /**
     * @param string $return
     */
    public function setReturn(string $return): void
    {
        $this->return = $return;
    }

    /**
     * @return string
     */
    public function getSender(): string
    {
        return $this->sender;
    }

    /**
     * @param string $sender
     */
    public function setSender(string $sender): void
    {
        $this->sender = $sender;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getPwd(): string
    {
        return $this->pwd;
    }

    /**
     * @param string $pwd
     */
    public function setPwd(string $pwd): void
    {
        $this->pwd = $pwd;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getInitialRequestData(): string
    {
        return $this->initialRequestData;
    }

    /**
     * @param string $initialRequestData
     */
    public function setInitialRequestData(string $initialRequestData): void
    {
        $this->initialRequestData = $initialRequestData;
    }

    /**
     * @return string
     */
    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }

    /**
     * @param string $redirectUrl
     */
    public function setRedirectUrl(string $redirectUrl): void
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * @return string
     */
    public function getReferenceId(): string
    {
        return $this->referenceId;
    }

    /**
     * @param string $referenceId
     */
    public function setReferenceId(string $referenceId): void
    {
        $this->referenceId = $referenceId;
    }

    /**
     * @return string
     */
    public function getStateId(): string
    {
        return $this->stateId;
    }

    /**
     * @param string $stateId
     */
    public function setStateId(string $stateId): void
    {
        $this->stateId = $stateId;
    }

    /**
     * @return string
     */
    public function getTotal(): string
    {
        $amount = number_format((int)$this->getPAmount() / 100, 2);
        return $amount . ' ' . $this->getPCurrency();
    }
}
